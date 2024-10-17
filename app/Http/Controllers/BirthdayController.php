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
use App\Models\Wilayah;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Unique;

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
            //...
        ];

        $tahun = date('Y');
        $gender = $request->input('Kelamin');
        $wilayah = $request->input('Wilayah');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $isiJemaat = Jemaat::select('jemaat.nama_jemaat', 'jemaat.tanggal_lahir', 'wilayah.nama_wilayah as wil')
            ->leftJoin('wilayah', 'jemaat.id_wilayah', '=', 'wilayah.id_wilayah')
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween(DB::raw('DATE_FORMAT(tanggal_lahir, "%m-%d")'), [
                    date('m-d', strtotime($startDate)),
                    date('m-d', strtotime($endDate))
                ]);
            })
            ->orderBy('wilayah.nama_wilayah')
            ->get();
        $monthNames = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Ags', 9 => 'Sept', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'];
        $status = Jemaat::selectRaw('status.keterangan_status as stat, COUNT(jemaat.id_status) as jumlah')
            ->join('status', 'jemaat.id_status','=','status.id_status' )
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender); 
            })
            ->when($wilayah && $wilayah !== '', function ($query) use ($wilayah) {
                return $query->where('jemaat.id_wilayah', $wilayah);
            })
            ->groupBy('stat')
            ->get();

        $dropWilayah = Wilayah::pluck('nama_wilayah', 'id_wilayah'); 
        $dropKab = Kabupaten::pluck('kabupaten','id_kabupaten');
        $dropKec = Kecamatan::pluck('kecamatan','id_kecamatan');
        $labelWilayah = $isiJemaat->pluck('wil')->keys()->toArray();
        $labelStatus =$status->pluck('stat');
        $jumlahStatus = $status->pluck('jumlah');

        $dataCount = $isiJemaat->groupBy('wil')->map(function ($group) {
            return $group->count();
        })->values()->toArray();
        $data = [
            'widget' => $widget,
            'jumlahJemaat' => $isiJemaat ->toArray(),
            'status' => $status ->toArray(),
        ];
        return view('admin.birthdayDash',compact('tahun','dropWilayah','labelWilayah','isiJemaat','labelStatus','jumlahStatus','dataCount'), $data);
    }
    

    // admin pengaturan start
    public function adminPengaturanWilayah()
    {
        return view('admin.pengaturan.wilayah');
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
