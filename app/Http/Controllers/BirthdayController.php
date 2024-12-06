<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kematian;
use App\Models\Jemaat;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\AtestasiMasuk;
use App\Models\AtestasiKeluar;
use App\Models\Pernikahan;
use App\Models\Wilayah;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Support\Carbon;

class BirthdayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // admin
    public function birthdayDashboard(Request $request)
    {
        $users = User::count();

        $widget = [
            'users' => $users,
        ];

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $showAllBirthdays = $request->input('showAllBirthdays') == 'true';
        $showAllMarriages = $request->input('showAllMarriages') == 'true';
    
        $birthdayItemsPerPage = $showAllBirthdays ? 8 : 8;
        $marriageItemsPerPage = $showAllMarriages ? 8 : 8;
        $isiJemaat = Jemaat::select('jemaat.nama_jemaat', 'jemaat.tanggal_lahir', 'wilayah.nama_wilayah as wil')
            ->leftJoin('wilayah', 'jemaat.id_wilayah', '=', 'wilayah.id_wilayah')
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $startMonthDay = date('m-d', strtotime($startDate));
                $endMonthDay = date('m-d', strtotime($endDate));  
                if ($startMonthDay > $endMonthDay) {
                    return $query->where(function($query) use ($startMonthDay, $endMonthDay) {
                        $query->whereBetween(DB::raw('DATE_FORMAT(tanggal_lahir, "%m-%d")'), [$startMonthDay, '12-31'])
                              ->orWhereBetween(DB::raw('DATE_FORMAT(tanggal_lahir, "%m-%d")'), ['01-01', $endMonthDay]);
                    });
                } else {
                    return $query->whereBetween(DB::raw('DATE_FORMAT(tanggal_lahir, "%m-%d")'), [$startMonthDay, $endMonthDay]);
                }
            })
            ->orderBy('wilayah.nama_wilayah')
            ->get();

        $weddingsByWilayah = Pernikahan::select(DB::raw('count(*) as total_weddings, pernikahan.id_wilayah, wilayah.nama_wilayah'))
            ->join('wilayah', 'pernikahan.id_wilayah', '=', 'wilayah.id_wilayah')
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $startMonthDay = date('m-d', strtotime($startDate));
                $endMonthDay = date('m-d', strtotime($endDate));
                
                if ($startMonthDay > $endMonthDay) {
                    return $query->where(function($query) use ($startMonthDay, $endMonthDay) {
                        $query->whereBetween(DB::raw('DATE_FORMAT(tanggal_nikah, "%m-%d")'), [$startMonthDay, '12-31'])
                              ->orWhereBetween(DB::raw('DATE_FORMAT(tanggal_nikah, "%m-%d")'), ['01-01', $endMonthDay]);
                    });
                } else {
                    return $query->whereBetween(DB::raw('DATE_FORMAT(tanggal_nikah, "%m-%d")'), [$startMonthDay, $endMonthDay]);
                }
            })
            ->groupBy('pernikahan.id_wilayah', 'wilayah.nama_wilayah')
            ->orderBy('wilayah.nama_wilayah')
            ->get();

        $pagination = Jemaat::select('jemaat.nama_jemaat', 'jemaat.tanggal_lahir', 'wilayah.nama_wilayah as wil')
            ->leftJoin('wilayah', 'jemaat.id_wilayah', '=', 'wilayah.id_wilayah')
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $startMonthDay = date('m-d', strtotime($startDate));
                $endMonthDay = date('m-d', strtotime($endDate));
                
                if ($startMonthDay > $endMonthDay) {
                    return $query->where(function($query) use ($startMonthDay, $endMonthDay) {
                        $query->whereBetween(DB::raw('DATE_FORMAT(tanggal_lahir, "%m-%d")'), [$startMonthDay, '12-31'])
                              ->orWhereBetween(DB::raw('DATE_FORMAT(tanggal_lahir, "%m-%d")'), ['01-01', $endMonthDay]);
                    });
                } else {
                    return $query->whereBetween(DB::raw('DATE_FORMAT(tanggal_lahir, "%m-%d")'), [$startMonthDay, $endMonthDay]);
                }
            })
                       
            ->orderBy('jemaat.tanggal_lahir')
            ->paginate($birthdayItemsPerPage, ['*'], 'birthdaysPage')
            ->withQueryString();
        
        $paginationMarried = Pernikahan::select('pernikahan.tanggal_nikah', 'pernikahan.pengantin_pria', 'pernikahan.pengantin_wanita', 'wilayah.nama_wilayah')
            ->join('wilayah', 'pernikahan.id_wilayah', '=', 'wilayah.id_wilayah')
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $startMonthDay = date('m-d', strtotime($startDate));
                $endMonthDay = date('m-d', strtotime($endDate));
                
                if ($startMonthDay > $endMonthDay) {
                    return $query->where(function($query) use ($startMonthDay, $endMonthDay) {
                        $query->whereBetween(DB::raw('DATE_FORMAT(tanggal_nikah, "%m-%d")'), [$startMonthDay, '12-31'])
                              ->orWhereBetween(DB::raw('DATE_FORMAT(tanggal_nikah, "%m-%d")'), ['01-01', $endMonthDay]);
                    });
                } else {
                    return $query->whereBetween(DB::raw('DATE_FORMAT(tanggal_nikah, "%m-%d")'), [$startMonthDay, $endMonthDay]);
                }
            })
            ->orderBy('pernikahan.tanggal_nikah')
            ->paginate($marriageItemsPerPage, ['*'], 'marriagesPage')
            ->withQueryString();      

        $isiJemaat->map(function($jemaat) {
            $jemaat->tanggal_lahir = Carbon::parse($jemaat->tanggal_lahir)->format('d-m-Y');
            return $jemaat;
        });
        $pagination->map(function($jemaat) {
            $jemaat->tanggal_lahir = Carbon::parse($jemaat->tanggal_lahir)->format('d-m-Y');
            return $jemaat;
        });
        $paginationMarried->map(function($pernikahan) {
            $pernikahan->tanggal_nikah = Carbon::parse($pernikahan->tanggal_nikah)->format('d-m-Y');
            return $pernikahan;
        });


        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
        $labelWilayah = $isiJemaat->pluck('wil')->unique()->values()->toArray();
        $wilayahNames = $weddingsByWilayah->pluck('nama_wilayah')->toArray();
        $weddingCounts = $weddingsByWilayah->pluck('total_weddings')->toArray();
        $dataCount = $isiJemaat->groupBy('wil')->map(function ($group) {
            return $group->count();
        })->values()->toArray();
        $dataMarried = $weddingsByWilayah->groupBy('wilayah.nama_wilayah')->map(function ($group) {
            return $group->count();
        })->values()->toArray();

        $data = [
            'widget' => $widget,
            'jumlahJemaat' => $isiJemaat ->toArray(),
        ];


        return view('admin.birthdayDash',compact('monthNames','pagination','labelWilayah','isiJemaat','paginationMarried','dataCount','dataMarried', 'wilayahNames', 'weddingCounts'), $data);
    }


    // admin pengaturan start
    public function adminPengaturanWilayah()
    {
        return view('admin.pengaturan.wilayah');
    }
    public function dashboardUsia()
    {
        return view('admin.dashboardUsia');
    }

    public function adminDashboard()
    {
        return view('admin.dashboard');
    }

    public function adminPengaturanJabatanMajelis()
    {
        return view('admin.pengaturan.jabatan-majelis');
    }

    public function adminPengaturanJabatanNonMajelis()
    {
        return view('admin.pengaturan.jabatan-non-majelis');
    }

    public function adminPengaturanUserAdmin()
    {
        return view('admin.pengaturan.user-admin');
    }

    public function adminReferensiPekerjaan()
    {
        return view('admin.pengaturan.referensi-pekerjaan');
    }

    public function adminReferensiDaerah()
    {
        return view('admin.pengaturan.referensi-daerah');
    }
    // admin pengaturan end

    // admin data start
    public function adminDataAnggotaJemaat()
    {
        return view('admin.data.anggota-jemaat');
    }

    public function adminDataAnggotaJemaatKeluarga()
    {
        return view('admin.data.anggota-jemaat-keluarga');
    }

    public function adminDataJemaatBaru()
    {
        return view('admin.data.jemaat-baru');
    }

    public function adminDataMajelis()
    {
        return view('admin.data.majelis');
    }

    public function adminDataNonMajelis()
    {
        return view('admin.data.non-majelis');
    }

    public function adminDataJemaatTitipan()
    {
        return view('admin.data.jemaat-titipan');
    }

    public function adminDataJemaatUltah()
    {
        return view('admin.data.jemaat-ultah');
    }

    public function adminDataJemaatUltahNikah()
    {
        return view('admin.data.jemaat-ultah-nikah');
    }
    // admin data end

    // admin transaksi start
    public function adminTransaksiPernikahan() {
        return view('admin.transaksi.pernikahan');
    }

    public function adminTransaksiKematian() {
        return view('admin.transaksi.kematian');
    }

    public function adminTransaksiAtestasiKeluar() {
        return view('admin.transaksi.atestasi-keluar');
    }

    public function adminTransaksiAtestasiMasuk() {
        return view('admin.transaksi.atestasi-masuk');
    }

    public function adminTransaksiBaptisAnak() {
        return view('admin.transaksi.baptis-anak');
    }

    public function adminTransaksiBaptisDewasa() {
        return view('admin.transaksi.baptis-dewasa');
    }

    public function adminTransaksiBaptisSidi() {
        return view('admin.transaksi.baptis-sidi');
    }
}
