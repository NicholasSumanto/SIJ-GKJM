<?php

namespace App\Http\Controllers;

use App\Models\JemaatBaru;
use App\Models\JemaatTitipan;
use App\Models\Kelurahan;
use App\Models\Provinsi;
use App\Models\User;
use App\Models\Jemaat;
use App\Models\Kematian;
use App\Models\Wilayah;
use App\Models\AtestasiKeluarDtl;
use App\Models\AtestasiMasuk;
use App\Models\BaptisAnak;
use App\Models\BaptisDewasa;
use App\Models\BaptisSidi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\RolePengguna as Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminWilayahPageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminWilayahDashboard(Request $request)
    {
        $users = User::count();

        $widget = [
            'users' => $users,
            //...
        ];

        $id_role = Auth::user()->id_role;
        $id_wilayah = Auth::user()->id_wilayah;
        if (!$id_wilayah) {
            return redirect()->back()->with('error', 'Wilayah not assigned to the user.');
        }    
        $tahun = date('Y');
        $bulan = date('M');
        $totalJemaat = Jemaat::where('id_wilayah','=', $id_wilayah)
        ->count();
        $perempuan = Jemaat::where('id_wilayah', $id_wilayah)
            ->where('kelamin', 'Perempuan')
            ->count();
        $laki = Jemaat::where('id_wilayah', $id_wilayah)
            ->where('kelamin', 'Laki-laki')
            ->count();

        $gender = $request->input('Kelamin');
        $wilayah = $request->input('Wilayah');
        $jemaatMeninggal = Kematian::selectRaw('MONTH(tanggal_meninggal) as bulan, COUNT(*) as jumlah')
            ->join('jemaat', 'kematian.id_jemaat', '=', 'jemaat.id_jemaat')
            ->join('wilayah', 'jemaat.id_wilayah', '=', 'wilayah.id_wilayah') // Join with wilayah table
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($id_wilayah, function ($query) use ($id_wilayah) {
                return $query->where('wilayah.id_wilayah', $id_wilayah);
            })
            ->groupBy('bulan')
            ->get();
        $baptisSidi = BaptisSidi::selectRaw('MONTH(baptis_sidi.tanggal_baptis) as bulan, COUNT(*) as total')
            ->join('jemaat', 'baptis_sidi.id_jemaat', '=', 'jemaat.id_jemaat')
            ->join('wilayah', 'jemaat.id_wilayah', '=', 'wilayah.id_wilayah') // Join with wilayah table
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($id_wilayah, function ($query) use ($id_wilayah) {
                return $query->where('baptis_sidi.id_wilayah', $id_wilayah);
            })
            ->groupBy('bulan')
            ->get();
        $baptisDewasa = BaptisDewasa::selectRaw('MONTH(baptis_dewasa.tanggal_baptis) as bulan, COUNT(*) as total')
            ->join('jemaat', 'jemaat.id_jemaat', '=', 'baptis_dewasa.id_jemaat')
            ->join('wilayah', 'jemaat.id_wilayah', '=', 'wilayah.id_wilayah') // Join with wilayah table
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($id_wilayah, function ($query) use ($id_wilayah) {
                return $query->where('baptis_dewasa.id_wilayah', $id_wilayah);
            })
            ->groupBy('bulan')
            ->get();
        $baptisAnak = BaptisAnak::selectRaw('MONTH(baptis_anak.tanggal_baptis) as bulan, COUNT(*) as total')
            ->join('jemaat', 'jemaat.id_jemaat', '=', 'baptis_anak.id_jemaat')
            ->join('wilayah', 'jemaat.id_wilayah', '=', 'wilayah.id_wilayah') // Join with wilayah table
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($id_wilayah, function ($query) use ($id_wilayah) {
                return $query->where('baptis_anak.id_wilayah', $id_wilayah);
            })
            ->groupBy('bulan')
            ->get();
        $atestasiMasuk = AtestasiMasuk::selectRaw('MONTH(tanggal_masuk) as bulan, COUNT(*) as jumlah')
            ->join('jemaat', 'atestasi_masuk.id_jemaat', '=', 'jemaat.id_jemaat')
            ->join('wilayah', 'jemaat.id_wilayah', '=', 'wilayah.id_wilayah') // Join with wilayah table
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($id_wilayah, function ($query) use ($id_wilayah) {
                return $query->where('wilayah.id_wilayah', $id_wilayah);
            })
            ->groupBy('bulan')
            ->get();

        $atestasiKeluar = AtestasiKeluarDtl::selectRaw('MONTH(tanggal) as bulan, COUNT(*) as jumlah')
            ->join('jemaat', 'atestasi_keluar_dtl.id_jemaat', '=', 'jemaat.id_jemaat')
            ->join('atestasi_keluar', 'atestasi_keluar_dtl.id_keluar', '=', 'atestasi_keluar.id_keluar')
            ->join('wilayah', 'jemaat.id_wilayah', '=', 'wilayah.id_wilayah') // Join with wilayah table
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($id_wilayah, function ($query) use ($id_wilayah) {
                return $query->where('wilayah.id_wilayah', $id_wilayah);
            })
            ->groupBy('bulan')
            ->get();
        $jumlahJemaat = Jemaat::selectRaw('wilayah.nama_wilayah as wil, COUNT(jemaat.id_wilayah) as jumlah')
            ->join('wilayah', 'jemaat.id_wilayah', '=', 'wilayah.id_wilayah')
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($id_wilayah, function ($query) use ($id_wilayah) {
                return $query->where('wilayah.id_wilayah', $id_wilayah);
            })
            ->groupBy('wil')
            ->get();
        $status = Jemaat::selectRaw('status.keterangan_status as stat, COUNT(jemaat.id_status) as jumlah')
            ->join('status', 'jemaat.id_status', '=', 'status.id_status')
            ->join('wilayah', 'jemaat.id_wilayah', '=', 'wilayah.id_wilayah') // Join with wilayah table
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($id_wilayah, function ($query) use ($id_wilayah) {
                return $query->where('wilayah.id_wilayah', $id_wilayah);
            })
            ->groupBy('stat')
            ->get();
        $allMonths = collect([
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'Mei',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Ags',
            9 => 'Sept',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des'
        ]); 
        $atestasiMasuk = $allMonths->map(function ($month, $key) use ($atestasiMasuk) {
            $record = $atestasiMasuk->firstWhere('bulan', $key); 
            return [
                'bulan' => $month,
                'jumlah' => $record ? $record->jumlah : 0,
            ];
        });
        $atestasiKeluar = $allMonths->map(function ($month, $key) use ($atestasiKeluar) {
            $record = $atestasiKeluar->firstWhere('bulan', $key); 
            return [
                'bulan' => $month,
                'jumlah' => $record ? $record->jumlah : 0,
            ];
        });
        $jemaatMeninggal = $allMonths->map(function ($month, $key) use ($jemaatMeninggal) {
            $record = $jemaatMeninggal->firstWhere('bulan', $key); 
            return [
                'bulan' => $month,
                'jumlah' => $record ? $record->jumlah : 0,
            ];
        });
        $baptisAnak = $allMonths->map(function ($month, $key) use ($baptisAnak) {
            $record = $baptisAnak->firstWhere('bulan', $key);

            return [
                'bulan' => $month,
                'total' => $record ? $record->total : 0,
            ];
        });
        $baptisDewasa = $allMonths->map(function ($month, $key) use ($baptisDewasa) {
            $record = $baptisDewasa->firstWhere('bulan', $key);

            return [
                'bulan' => $month,
                'total' => $record ? $record->total : 0,
            ];
        });
        $baptisSidi = $allMonths->map(function ($month, $key) use ($baptisSidi) {
            $record = $baptisSidi->firstWhere('bulan', $key);

            return [
                'bulan' => $month,
                'total' => $record ? $record->total : 0,
            ];
        });

        $labelWilayah = $jumlahJemaat->pluck('wil');
        $isiJemaat = $jumlahJemaat->pluck('jumlah');
        $labelBulan = $jemaatMeninggal->pluck('bulan');
        $isiKematian = $jemaatMeninggal->pluck('jumlah');
        $isiBA = $baptisAnak->pluck('total');
        $isiBS = $baptisSidi->pluck('total');
        $isiBD = $baptisDewasa->pluck('total');
        $labelBaptis = $baptisAnak->pluck('bulan');
        $isiMasuk = $atestasiMasuk->pluck('jumlah');
        $isiKeluar = $atestasiKeluar->pluck('jumlah');;
        $labelStatus =$status->pluck('stat');
        $jumlahStatus = $status->pluck('jumlah');
        $data = [
            'widget' => $widget,
            'jumlahJemaat' => $jumlahJemaat ->toArray(),
            'jemaatMeninggal' => $jemaatMeninggal ->toArray(),
            'baptisAnak' => $baptisAnak->toArray(),
            'baptisSidi' => $baptisSidi->toArray(),
            'baptisDewasa' => $baptisDewasa->toArray(),
            'atestasiMasuk' => $atestasiMasuk->toArray(),
            'atestasiKeluar' => $atestasiKeluar->toArray(),
            'status' => $status ->toArray(),
        ];


        return view('admin-wilayah.dashboard',compact('tahun','bulan', 'totalJemaat', 'perempuan', 'laki', 'labelWilayah','isiJemaat','labelBulan','isiKematian','labelBaptis','isiBA','isiBS','isiBD','isiMasuk','isiKeluar','labelStatus', 'jumlahStatus'), $data);
    }
    public function adminWilayahDataAnggotaJemaat()
    {
        return view('admin-wilayah.data.anggota-jemaat');
    }

    public function adminWilayahDataAnggotaJemaatDetail($id, $validasi)
    {
        if($validasi == "tidak valid"){
            $jemaat = JemaatBaru::find($id);
        } else {
            $jemaat = Jemaat::find($id);
            $jemaat->validasi = $validasi;
        }

        if ($jemaat->id_kelurahan != null) {
            $jemaat->nama_kelurahan = Kelurahan::find($jemaat->id_kelurahan)->kelurahan;
        }

        if ($jemaat->id_kecamatan != null) {
            $jemaat->nama_kecamatan = Kecamatan::find($jemaat->id_kecamatan)->kecamatan;
        }

        if ($jemaat->id_kabupaten != null) {
            $jemaat->nama_kabupaten = Kabupaten::find($jemaat->id_kabupaten)->kabupaten;
        }

        if ($jemaat->id_provinsi != null) {
            $jemaat->nama_provinsi = Provinsi::find($jemaat->id_provinsi)->nama_provinsi;
        }

        $jemaat->photo_url = $jemaat->photo ? Storage::url($jemaat->photo) : null;

        return view('admin-wilayah.data.anggota-jemaat-detail', compact('jemaat'));
    }
    public function adminWilayahDataAnggotaJemaatKeluarga()
    {
        return view('admin-wilayah.data.anggota-jemaat-keluarga');
    }
}
