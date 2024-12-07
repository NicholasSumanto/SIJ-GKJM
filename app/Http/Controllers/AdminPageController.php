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
use App\Models\BaptisAnak;
use App\Models\JemaatBaru;
use App\Models\BaptisDewasa;
use App\Models\BaptisSidi;
use App\Models\Provinsi;
use App\Models\Wilayah;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        $perempuan = Jemaat::where('kelamin', '=', 'Perempuan')->count();
        $laki = Jemaat::where('kelamin', '=', 'Laki-laki')->count();
        $wilayah = $request->input('Wilayah');
        $totalJemaatWilayah = Jemaat::selectRaw('id_jemaat')
            ->when($kabupaten, function ($query, $kabupaten) {
                return $query->where('jemaat.id_kabupaten', $kabupaten);
            })
            ->when($kecamatan, function ($query, $kecamatan) {
                return $query->where('jemaat.id_kecamatan', $kecamatan);
            })
            ->count('id_jemaat');
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
            ->whereYear('kematian.tanggal_meninggal', $tahun)
            ->groupBy('bulan')
            ->get();
        $baptisSidi = BaptisSidi::selectRaw('MONTH(baptis_sidi.tanggal_baptis) as bulan, COUNT(*) as total')
            ->join('jemaat', 'baptis_sidi.id_jemaat', '=', 'jemaat.id_jemaat')
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($wilayah && $wilayah !== '', function ($query) use ($wilayah) {
                return $query->where('jemaat.id_wilayah', $wilayah);
            })
            ->whereYear('baptis_sidi.tanggal_baptis', $tahun)
            ->groupBy('bulan')
            ->get();
        $baptisDewasa = BaptisDewasa::selectRaw('MONTH(baptis_dewasa.tanggal_baptis) as bulan, COUNT(*) as total')
            ->join('jemaat', 'baptis_dewasa.id_jemaat', '=', 'jemaat.id_jemaat')
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($wilayah && $wilayah !== '', function ($query) use ($wilayah) {
                return $query->where('jemaat.id_wilayah', $wilayah);
            })
            ->whereYear('baptis_dewasa.tanggal_baptis', $tahun)
            ->groupBy('bulan')
            ->get();
        $baptisAnak = BaptisAnak::selectRaw('MONTH(baptis_anak.tanggal_baptis) as bulan, COUNT(*) as total')
            ->join('jemaat', 'baptis_anak.id_jemaat', '=', 'jemaat.id_jemaat')
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($wilayah && $wilayah !== '', function ($query) use ($wilayah) {
                return $query->where('jemaat.id_wilayah', $wilayah);
            })
            ->whereYear('baptis_anak.tanggal_baptis', $tahun)
            ->groupBy('bulan')
            ->get();
        $atestasiMasuk = AtestasiMasuk::selectRaw('MONTH(atestasi_masuk.tanggal_masuk) as bulan, COUNT(*) as jumlah')
            ->join('jemaat', 'atestasi_masuk.id_jemaat', '=', 'jemaat.id_jemaat')
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($wilayah && $wilayah !== '', function ($query) use ($wilayah) {
                return $query->where('jemaat.id_wilayah', $wilayah);
            })
            ->whereYear('atestasi_masuk.tanggal_masuk', $tahun)
            ->groupBy('bulan')
            ->get();
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

        $status = Jemaat::selectRaw('status.keterangan_status as stat, COUNT(jemaat.id_status) as jumlah')
            ->join('status', 'jemaat.id_status', '=', 'status.id_status')
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($wilayah && $wilayah !== '', function ($query) use ($wilayah) {
                return $query->where('jemaat.id_wilayah', $wilayah);
            })
            ->groupBy('stat')
            ->get();

        $dropWilayah = Wilayah::pluck('nama_wilayah', 'id_wilayah');
        $dropKab = Kabupaten::pluck('kabupaten', 'id_kabupaten');
        $kab = Kabupaten::all();
        $kec = Kecamatan::all();
        $dropKec = Kecamatan::pluck('kecamatan', 'id_kecamatan');
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
        $labelBD = $baptisDewasa->pluck('bulan');
        $labelBS = $baptisSidi->pluck('bulan');
        $labelAt = $atestasiMasuk->pluck('bulan');
        $isiMasuk = $atestasiMasuk->pluck('jumlah');
        $isiKeluar = $atestasiKeluar->pluck('jumlah');;
        $labelStatus =$status->pluck('stat');
        $jumlahStatus = $status->pluck('jumlah');


        $data = [
            'widget' => $widget,
            'jumlahJemaat' => $jumlahJemaat->toArray(),
            'jemaatMeninggal' => $jemaatMeninggal->toArray(),
            'baptisAnak' => $baptisAnak->toArray(),
            'baptisSidi' => $baptisSidi->toArray(),
            'baptisDewasa' => $baptisDewasa->toArray(),
            'atestasiMasuk' => $atestasiMasuk->toArray(),
            'atestasiKeluar' => $atestasiKeluar->toArray(),
            'status' => $status ->toArray(),
        ];
        return view('admin.dashboard',compact('tahun', 'perempuan', 'laki', 'isiBoy','isiGirl','totalJemaat','dropWilayah', 'dropKab','dropKec','kab','kec','totalJemaatWilayah','labelWilayah','isiJemaat','labelBulan', 'labelAt', 'isiKematian','labelBaptis','labelBD','labelBS','isiBA','isiBS','isiBD','isiMasuk','isiKeluar','labelStatus','jumlahStatus'), $data);
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

    public function adminDataAnggotaJemaatBaruDetail($id)
    {
        $jemaat = JemaatBaru::find($id);

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

        return view('admin.data.jemaat-baru-detail', compact('jemaat'));
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
    public function adminTransaksiPernikahan()
    {
        return view('admin.transaksi.pernikahan');
    }

    public function adminTransaksiKematian()
    {
        return view('admin.transaksi.kematian');
    }

    public function adminTransaksiAtestasiKeluar()
    {
        return view('admin.transaksi.atestasi-keluar');
    }
    public function adminTransaksiAtestasiKeluarDetail($id)
    {
        $atestasiKeluarDetail = AtestasiKeluarDtl::find($id);
        $id_keluar = AtestasiKeluar::find($id)->id_keluar;

        return view('admin.transaksi.atestasi-keluar-detail', compact('atestasiKeluarDetail', 'id_keluar'));
    }

    public function adminTransaksiAtestasiMasuk()
    {
        return view('admin.transaksi.atestasi-masuk');
    }

    public function adminTransaksiBaptisAnak()
    {
        return view('admin.transaksi.baptis-anak');
    }

    public function adminTransaksiBaptisDewasa()
    {
        return view('admin.transaksi.baptis-dewasa');
    }

    public function adminTransaksiBaptisSidi()
    {
        return view('admin.transaksi.baptis-sidi');
    }
}
