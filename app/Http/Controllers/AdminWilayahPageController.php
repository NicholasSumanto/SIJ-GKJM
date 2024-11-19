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
use App\Models\AtestasiKeluar;
use App\Models\AtestasiMasuk;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use Illuminate\Support\Facades\DB;
use App\Models\RolePengguna as Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Storage;

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
        $nama_wilayah = Role::where('id_role', $id_role)->first()->nama_role;

        $wilayahName = null;
        if (preg_match('/Wilayah \d+([A-Z])?/', $nama_wilayah, $matches)) {
        $wilayahName = $matches[0];}
        $id_wilayah = Wilayah::where('nama_wilayah', $wilayahName)->first()->id_wilayah;
        $tahun = date('Y');
        $bulan = date('M');

        $gender = $request->input('Kelamin');
        $wilayah = $request->input('Wilayah');
        $jemaatMeninggal = Kematian::selectRaw('MONTH(tanggal_meninggal) as bulan, COUNT(*) as jumlah')
            ->join('jemaat', 'kematian.id_jemaat', '=', 'jemaat.id_jemaat')
            ->join('wilayah', 'jemaat.id_wilayah', '=', 'wilayah.id_wilayah') // Join with wilayah table
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($wilayahName, function ($query) use ($wilayahName) {
                return $query->where('wilayah.nama_wilayah', $wilayahName);
            })
            ->groupBy('bulan')
            ->get();
        $baptisSidi = Jemaat::select(DB::raw('MONTH(baptis_sidi.tanggal_baptis) as bulan'), DB::raw('COUNT(jemaat.id_sidi) as total'))
            ->join('baptis_sidi', 'jemaat.id_sidi', '=', 'baptis_sidi.id_sidi')
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($id_wilayah, function ($query) use ($id_wilayah) {
                return $query->where('baptis_sidi.id_wilayah', $id_wilayah);
            })
            ->groupBy('bulan')
            ->get();
        $baptisDewasa = Jemaat::select(DB::raw('MONTH(baptis_dewasa.tanggal_baptis) as bulan'), DB::raw('COUNT(jemaat.id_bd) as total'))
            ->join('baptis_dewasa', 'jemaat.id_bd', '=', 'baptis_dewasa.id_bd')
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($id_wilayah, function ($query) use ($id_wilayah) {
                return $query->where('baptis_dewasa.id_wilayah', $id_wilayah);
            })
            ->groupBy('bulan')
            ->get();
        $baptisAnak = Jemaat::select(DB::raw('MONTH(baptis_anak.tanggal_baptis) as bulan'), DB::raw('COUNT(jemaat.id_ba) as total'))
            ->join('baptis_anak', 'jemaat.id_ba', '=', 'baptis_anak.id_ba')
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($id_wilayah, function ($query) use ($id_wilayah) {
                return $query->where('baptis_anak.id_wilayah', $id_wilayah);
            })
            ->groupBy('bulan')
            ->get();
        $atestasiMasuk = AtestasiMasuk::selectRaw('MONTH(tanggal) as bulan, COUNT(*) as jumlah')
            ->join('jemaat', 'atestasi_masuk.id_jemaat', '=', 'jemaat.id_jemaat')
            ->join('wilayah', 'jemaat.id_wilayah', '=', 'wilayah.id_wilayah') // Join with wilayah table
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($wilayahName, function ($query) use ($wilayahName) {
                return $query->where('wilayah.nama_wilayah', $wilayahName);
            })
            ->groupBy('bulan')
            ->get();

        $atestasiKeluar = AtestasiKeluar::selectRaw('MONTH(tanggal) as bulan, COUNT(*) as jumlah')
            ->join('jemaat', 'atestasi_keluar.id_jemaat', '=', 'jemaat.id_jemaat')
            ->join('wilayah', 'jemaat.id_wilayah', '=', 'wilayah.id_wilayah') // Join with wilayah table
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($wilayahName, function ($query) use ($wilayahName) {
                return $query->where('wilayah.nama_wilayah', $wilayahName);
            })
            ->groupBy('bulan')
            ->get();
        $jumlahJemaat = Jemaat::selectRaw('wilayah.nama_wilayah as wil, COUNT(jemaat.id_wilayah) as jumlah')
            ->join('wilayah', 'jemaat.id_wilayah', '=', 'wilayah.id_wilayah')
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($wilayahName, function ($query) use ($wilayahName) {
                return $query->where('wilayah.nama_wilayah', $wilayahName);
            })
            ->groupBy('wil')
            ->get();
        $pendidikan = Jemaat::selectRaw('pendidikan.nama_pendidikan as tingkatan, COUNT(jemaat.id_pendidikan) as jumlah')
            ->join('pendidikan', 'jemaat.id_pendidikan','=','pendidikan.id_pendidikan' )
            ->join('wilayah', 'jemaat.id_wilayah', '=', 'wilayah.id_wilayah') // Join with wilayah table
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($wilayahName, function ($query) use ($wilayahName) {
                return $query->where('wilayah.nama_wilayah', $wilayahName);
            })
            ->groupBy('tingkatan')
            ->get();
        $monthNames = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Ags', 9 => 'Sept', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'];

        $jemaatMeninggal = $jemaatMeninggal->map(function($item) use ($monthNames) {
            $item->bulan = $monthNames[$item->bulan];
            return $item;
        });
        $baptisAnak = $baptisAnak->map(function($item) use ($monthNames) {
            $item->bulan = $monthNames[$item->bulan];
            return $item;
        });
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
        $isiPendidikan = $pendidikan->pluck('jumlah');
        $labelPendidikan =$pendidikan->pluck('tingkatan');
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
            'pendidikan' => $pendidikan ->toArray(),
            'status' => $status ->toArray(),
        ];


        return view('admin-wilayah.dashboard',compact('tahun','bulan','dropWilayah','dropKab','dropKec','labelWilayah','isiJemaat','labelBulan','isiKematian','labelBaptis','isiBA','isiBS','isiBD','isiMasuk','isiKeluar','isiPendidikan','labelPendidikan', 'labelStatus', 'jumlahStatus'), $data);
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
