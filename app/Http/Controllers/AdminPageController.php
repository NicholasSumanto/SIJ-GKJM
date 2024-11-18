<?php

namespace App\Http\Controllers;

use App\Models\AtestasiKeluarDtl;
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
use Illuminate\Support\Facades\DB;

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

        $tahun = date('Y');
        $totalJemaat = Jemaat::count();
        $gender = $request->input('Kelamin');
        $kecamatan = $request->input('kecamatan');
        $kabupaten = $request->input('kabupaten');
        $totalJemaatWilayah = Jemaat::selectRaw('id_wilayah')
            ->when($kabupaten, function ($query, $kabupaten) {
                return $query->where('jemaat.id_kabupaten', $kabupaten);
            })
            ->when($kecamatan, function ($query, $kecamatan) {
                return $query->where('jemaat.id_kecamatan', $kecamatan);
            })
            ->count('id_wilayah');
        $pertumbuhanJemaat = Jemaat::selectRaw('MONTH(created_at) as bulan, COUNT(*) as jumlah')
            ->groupBy('bulan')
            ->get();
        
        $girl = Jemaat::selectRaw('MONTH(created_at) as bulan, COUNT(*) as jumlah')
            ->where('jemaat.kelamin', 'Perempuan')
            ->groupBy('bulan')
            ->get();
        $boy = Jemaat::selectRaw('MONTH(created_at) as bulan, COUNT(*) as jumlah')
            ->where('jemaat.kelamin', 'Laki-laki')
            ->groupBy('bulan')
            ->get();
        $jemaatMeninggal = Kematian::selectRaw('MONTH(tanggal_meninggal) as bulan, COUNT(*) as jumlah')
            ->join('jemaat', 'kematian.id_jemaat', '=', 'jemaat.id_jemaat')
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->groupBy('bulan')
            ->get();
        $baptisSidi = Jemaat::select(DB::raw('MONTH(baptis_sidi.tanggal_baptis) as bulan'), DB::raw('COUNT(jemaat.id_sidi) as total'))
            ->join('baptis_sidi', 'jemaat.id_sidi', '=', 'baptis_sidi.id_sidi')
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->groupBy('bulan')
            ->get();
        $baptisDewasa = Jemaat::select(DB::raw('MONTH(baptis_dewasa.tanggal_baptis) as bulan'), DB::raw('COUNT(jemaat.id_bd) as total'))
            ->join('baptis_dewasa', 'jemaat.id_bd', '=', 'baptis_dewasa.id_bd')
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })

            ->groupBy('bulan')
            ->get();
        $baptisAnak = Jemaat::select(DB::raw('MONTH(baptis_anak.tanggal_baptis) as bulan'), DB::raw('COUNT(jemaat.id_ba) as total'))
            ->join('baptis_anak', 'jemaat.id_ba', '=', 'baptis_anak.id_ba')
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })

            ->groupBy('bulan')
            ->get();
        $atestasiMasuk = AtestasiMasuk::selectRaw('MONTH(tanggal) as bulan, COUNT(*) as jumlah')
            ->join('jemaat', 'atestasi_masuk.id_jemaat', '=', 'jemaat.id_jemaat')

            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })

            ->groupBy('bulan')
            ->get();

        $atestasiKeluar = AtestasiKeluarDtl::selectRaw('MONTH(tanggal) as bulan, COUNT(*) as jumlah')
            ->join('jemaat', 'atestasi_keluar_dtl.id_jemaat', '=', 'jemaat.id_jemaat')
            ->join('atestasi_keluar', 'atestasi_keluar_dtl.id_keluar', '=', 'atestasi_keluar.id_keluar')
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->groupBy('bulan')
            ->get();
        
        $jumlahJemaat = Jemaat::selectRaw('wilayah.nama_wilayah as wil, COUNT(jemaat.id_wilayah) as jumlah')
            ->join('wilayah', 'jemaat.id_wilayah', '=', 'wilayah.id_wilayah')
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })

            ->groupBy('wil')
            ->get();
        $pendidikan = Jemaat::selectRaw('pendidikan.nama_pendidikan as tingkatan, COUNT(jemaat.id_pendidikan) as jumlah')
            ->join('pendidikan', 'jemaat.id_pendidikan','=','pendidikan.id_pendidikan' )
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
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
        $labelPertumbuhan = $pertumbuhanJemaat->map(function($item) use ($monthNames) {
            $item->bulan = $monthNames[$item->bulan];
            return $item;
        });
        $status = Jemaat::selectRaw('status.keterangan_status as stat, COUNT(jemaat.id_status) as jumlah')
            ->join('status', 'jemaat.id_status','=','status.id_status' )
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            // ->when($wilayah && $wilayah !== '', function ($query) use ($wilayah) {
            //     return $query->where('jemaat.id_wilayah', $wilayah);
            // })
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
        $pertumbuhan = $pertumbuhanJemaat->pluck('jumlah');
        $labelPertumbuhan = $pertumbuhanJemaat->pluck('bulan');
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
            'pertumbuhanJemaat' => $pertumbuhanJemaat->toArray(),
            'baptisDewasa' => $baptisDewasa->toArray(),
            'atestasiMasuk' => $atestasiMasuk->toArray(),
            'atestasiKeluar' => $atestasiKeluar->toArray(),
            'pendidikan' => $pendidikan ->toArray(),
            'status' => $status ->toArray(),
        ];
        return view('admin.dashboard',compact('tahun','isiBoy','isiGirl','pertumbuhan','labelPertumbuhan','totalJemaat','dropKab','dropKec','totalJemaatWilayah','labelWilayah','isiJemaat','labelBulan','isiKematian','labelBaptis','isiBA','isiBS','isiBD','isiMasuk','isiKeluar','isiPendidikan','labelPendidikan','labelStatus','jumlahStatus'), $data);
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
