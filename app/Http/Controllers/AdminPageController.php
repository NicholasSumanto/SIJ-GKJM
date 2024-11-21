<?php

namespace App\Http\Controllers;

use App\Models\AtestasiKeluarDtl;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kematian;
use App\Models\Jemaat;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\AtestasiMasuk;
use App\Models\AtestasiKeluar;
use App\Models\Provinsi;
use App\Models\Wilayah;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Storage;

class AdminPageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // admin
    public function adminDashboard(Request $request)
    {
        $users = User::count();

        $widget = [
            'users' => $users,
            //...
        ];

        $tahun = $request->input('tahun', date('Y'));
        $totalJemaat = Jemaat::count();
        $gender = $request->input('Kelamin');
        $kecamatan = $request->input('kecamatan');
        $kabupaten = $request->input('kabupaten');
        $perempuan = Jemaat::where('kelamin','=', 'Perempuan')->count();
        $laki = Jemaat::where('kelamin','=', 'Laki-laki')->count();
        $wilayah = $request->input('Wilayah');
        $totalJemaatWilayah = Jemaat::selectRaw('id_wilayah')
            ->when($kabupaten, function ($query, $kabupaten) {
                return $query->where('jemaat.id_kabupaten', $kabupaten);
            })
            ->when($kecamatan, function ($query, $kecamatan) {
                return $query->where('jemaat.id_kecamatan', $kecamatan);
            })
            ->count('id_wilayah');
        $girl = Jemaat::selectRaw('MONTH(created_at) as bulan, COUNT(*) as jumlah')
            ->when($wilayah && $wilayah !== '', function ($query) use ($wilayah) {
                return $query->where('jemaat.id_wilayah', $wilayah);
            })
            ->where('jemaat.kelamin', 'Perempuan')
            ->groupBy('bulan')
            ->get();
        $boy = Jemaat::selectRaw('MONTH(created_at) as bulan, COUNT(*) as jumlah')
            ->when($wilayah && $wilayah !== '', function ($query) use ($wilayah) {
                return $query->where('jemaat.id_wilayah', $wilayah);
            })
            ->where('jemaat.kelamin', 'Laki-laki')
            ->groupBy('bulan')
            ->get();
        $jemaatMeninggal = Kematian::selectRaw('MONTH(tanggal_meninggal) as bulan, COUNT(*) as jumlah')
            ->join('jemaat', 'kematian.id_jemaat', '=', 'jemaat.id_jemaat')
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($wilayah && $wilayah !== '', function ($query) use ($wilayah) {
                return $query->where('jemaat.id_wilayah', $wilayah);
            })
            ->groupBy('bulan')
            ->get();
        $baptisSidi = Jemaat::selectRaw('MONTH(baptis_sidi.tanggal_baptis) as bulan, COUNT(*) as total')
            ->join('baptis_sidi', 'jemaat.id_sidi', '=', 'baptis_sidi.id_sidi')
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($wilayah && $wilayah !== '', function ($query) use ($wilayah) {
                return $query->where('jemaat.id_wilayah', $wilayah);
            })
            ->whereYear('baptis_sidi.tanggal_baptis', $tahun)
            ->groupBy('bulan')
            ->get();
        $baptisDewasa = Jemaat::selectRaw('MONTH(baptis_dewasa.tanggal_baptis) as bulan, COUNT(*) as total')
            ->join('baptis_dewasa', 'jemaat.id_bd', '=', 'baptis_dewasa.id_bd')
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($wilayah && $wilayah !== '', function ($query) use ($wilayah) {
                return $query->where('jemaat.id_wilayah', $wilayah);
            })
            ->whereYear('baptis_dewasa.tanggal_baptis', $tahun)
            ->groupBy('bulan')
            ->get();
        $baptisAnak = Jemaat::selectRaw('MONTH(baptis_anak.tanggal_baptis) as bulan, COUNT(*) as total')
            ->join('baptis_anak', 'jemaat.id_ba', '=', 'baptis_anak.id_ba')
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($wilayah && $wilayah !== '', function ($query) use ($wilayah) {
                return $query->where('jemaat.id_wilayah', $wilayah);
            })
            ->whereYear('baptis_anak.tanggal_baptis', $tahun)
            ->groupBy('bulan')
            ->get();
        $atestasiMasuk = AtestasiMasuk::selectRaw('MONTH(atestasi_masuk.tanggal) as bulan, COUNT(*) as jumlah')
            ->join('jemaat', 'atestasi_masuk.id_jemaat', '=', 'jemaat.id_jemaat')
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($wilayah && $wilayah !== '', function ($query) use ($wilayah) {
                return $query->where('jemaat.id_wilayah', $wilayah);
            })
            ->whereYear('atestasi_masuk.tanggal', $tahun)
            ->groupBy('bulan')
            ->get();
            // dd($atestasiMasuk);
        $atestasiKeluar = AtestasiKeluar::selectRaw('MONTH(atestasi_keluar.tanggal) as bulan, COUNT(DISTINCT atestasi_keluar_dtl.id_jemaat) as jumlah')
            ->join('atestasi_keluar_dtl', 'atestasi_keluar.id_keluar', '=', 'atestasi_keluar_dtl.id_keluar')
            ->join('jemaat', 'atestasi_keluar_dtl.id_jemaat', '=', 'jemaat.id_jemaat')
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($wilayah && $wilayah !== '', function ($query) use ($wilayah) {
                return $query->where('jemaat.id_wilayah', $wilayah);
            })
            ->whereYear('atestasi_keluar.tanggal', $tahun)
            ->groupBy('bulan')
            ->get();
        
        $jumlahJemaat = Jemaat::selectRaw('wilayah.nama_wilayah as wil, COUNT(jemaat.id_wilayah) as jumlah')
            ->join('wilayah', 'jemaat.id_wilayah', '=', 'wilayah.id_wilayah')
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($wilayah && $wilayah !== '', function ($query) use ($wilayah) {
                return $query->where('jemaat.id_wilayah', $wilayah);
            })
            ->groupBy('wil')
            ->get();
        $pendidikan = Jemaat::selectRaw('pendidikan.nama_pendidikan as tingkatan, COUNT(jemaat.id_pendidikan) as jumlah')
            ->join('pendidikan', 'jemaat.id_pendidikan','=','pendidikan.id_pendidikan' )
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($wilayah && $wilayah !== '', function ($query) use ($wilayah) {
                return $query->where('jemaat.id_wilayah', $wilayah);
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
        $allMonths = collect([
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Ags', 
            9 => 'Sept', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ]);
        
        $atestasiMasuk = $allMonths->map(function ($month, $key) use ($atestasiMasuk) {
            $record = $atestasiMasuk->firstWhere('bulan', $key);
        
            return [
                'bulan' => $month,
                'jumlah' => $record ? $record->jumlah : 0,
            ];
        });
        
        $status = Jemaat::selectRaw('status.keterangan_status as stat, COUNT(jemaat.id_status) as jumlah')
            ->join('status', 'jemaat.id_status','=','status.id_status' )
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
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
        $isiGirl = $girl->pluck('jumlah');
        $isiBoy = $boy->pluck('jumlah');
        $isiBD = $baptisDewasa->pluck('total');
        $labelBaptis = $baptisAnak->pluck('bulan');
        $labelAt = $atestasiMasuk->pluck('bulan');
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
        return view('admin.dashboard',compact('tahun','perempuan', 'laki', 'isiBoy','isiGirl','totalJemaat','dropWilayah', 'dropKab','dropKec','totalJemaatWilayah','labelWilayah','isiJemaat','labelBulan', 'labelAt', 'isiKematian','labelBaptis','isiBA','isiBS','isiBD','isiMasuk','isiKeluar','isiPendidikan','labelPendidikan','labelStatus','jumlahStatus'), $data);
    }

    // admin pengaturan start
    public function adminPengaturanWilayah()
    {
        return view('admin.pengaturan.wilayah');
    }

    public function geoDashboard()
    {
        return view('admin.birthdayDash');
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

    public function adminReferensiDaerahKabupaten($id_provinsi)
    {
        $provinsi = Provinsi::find($id_provinsi);
        return view('admin.pengaturan.referensi-daerah-kabupaten')->with('provinsi', $provinsi);
    }

    public function adminReferensiDaerahKecamatan($id_kabupaten)
    {
        $kabupaten = Kabupaten::find(id: $id_kabupaten);
        $provinsi = Provinsi::find($kabupaten->id_provinsi);
        return view('admin.pengaturan.referensi-daerah-kecamatan', compact('kabupaten', 'provinsi'));
    }

    public function adminReferensiDaerahKelurahan($id_kecamatan)
    {
        $kecamatan = Kecamatan::find($id_kecamatan);
        $kabupaten = Kabupaten::find($kecamatan->id_kabupaten);
        $provinsi = Provinsi::find($kabupaten->id_provinsi);
        return view('admin.pengaturan.referensi-daerah-kelurahan', compact('kecamatan', 'kabupaten', 'provinsi'));
    }
    // admin pengaturan end

    // admin data start
    public function adminDataAnggotaJemaat()
    {
        return view('admin.data.anggota-jemaat');
    }

    public function adminDataAnggotaJemaatDetail($id)
    {
        $jemaat = Jemaat::find($id);
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

        return view('admin.data.anggota-jemaat-detail', compact('jemaat'));
    }

    public function adminDataAnggotaJemaatKeluarga()
    {
        return view('admin.data.anggota-jemaat-keluarga');
    }

    public function adminDataJemaatBaru()
    {
        return view('admin.data.jemaat-baru');
    }

    public function adminDataPendeta()
    {
        return view('admin.data.pendeta');
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
    public function adminTransaksiAtestasiKeluarDetail($id) {
        $atestasiKeluarDetail = AtestasiKeluarDtl::find($id);
        return view('admin.transaksi.atestasi-keluar-detail', compact('atestasiKeluarDetail'));
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
