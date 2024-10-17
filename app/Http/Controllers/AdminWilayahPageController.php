<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kematian;
use App\Models\Jemaat;
use App\Models\AtestasiMasuk;
use App\Models\AtestasiKeluar;
use App\Models\Wilayah;
use App\Models\RolePengguna as Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminWilayahPageController extends Controller
{
    public function adminWilayahDashboard(Request $request)
    {
        $users = User::count();

        $widget = [
            'users' => $users,
            //...
        ];

        $id_role = Auth::user()->id_role;
        $nama_wilayah = Role::where('id_role', $id_role)->first()->nama_role;

        // $tahun = Carbon::today()->year;
        $tahun = date('Y');
        $gender = $request->input('Kelamin');
        $wilayah = preg_replace("/Admin Wilayah\s*/", "", $nama_wilayah);
        $jemaatMeninggal = Kematian::selectRaw('MONTH(tanggal_meninggal) as bulan, COUNT(*) as jumlah')
            ->join('jemaat', 'kematian.id_jemaat', '=', 'jemaat.id_jemaat')
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($wilayah && $wilayah !== '', function ($query) use ($wilayah) {
                return $query->where('jemaat.id_wilayah', $wilayah);
            })
            ->whereYear('tanggal_meninggal', $tahun)
            ->groupBy('bulan')
            ->get();
        $baptisSidi = Jemaat::select(DB::raw('MONTH(baptis_sidi.tanggal_baptis) as bulan'), DB::raw('COUNT(jemaat.id_sidi) as total'))
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
        $baptisDewasa = Jemaat::select(DB::raw('MONTH(baptis_dewasa.tanggal_baptis) as bulan'), DB::raw('COUNT(jemaat.id_bd) as total'))
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
        $baptisAnak = Jemaat::select(DB::raw('MONTH(baptis_anak.tanggal_baptis) as bulan'), DB::raw('COUNT(jemaat.id_ba) as total'))
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
        $atestasiMasuk = AtestasiMasuk::selectRaw('MONTH(tanggal) as bulan, COUNT(*) as jumlah')
            ->join('jemaat', 'atestasi_masuk.id_jemaat', '=', 'jemaat.id_jemaat')
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($wilayah && $wilayah !== '', function ($query) use ($wilayah) {
                return $query->where('jemaat.id_wilayah', $wilayah);
            })
            ->whereYear('atestasi_masuk.created_at', $tahun)
            ->groupBy('bulan')
            ->get();

        $atestasiKeluar = AtestasiKeluar::selectRaw('MONTH(tanggal) as bulan, COUNT(*) as jumlah')
            ->join('jemaat', 'atestasi_keluar.id_jemaat', '=', 'jemaat.id_jemaat')
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($wilayah && $wilayah !== '', function ($query) use ($wilayah) {
                return $query->where('jemaat.id_wilayah', $wilayah);
            })
            ->whereYear('tanggal', $tahun)
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
        $pendidikan = Jemaat::selectRaw('pendidikan.pendidikan as tingkatan, COUNT(jemaat.id_pendidikan) as jumlah')
            ->join('pendidikan', 'jemaat.id_pendidikan', '=', 'pendidikan.id_pendidikan')
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender);
            })
            ->when($wilayah && $wilayah !== '', function ($query) use ($wilayah) {
                return $query->where('jemaat.id_wilayah', $wilayah);
            })
            ->groupBy('tingkatan')
            ->get();
        $monthNames = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Ags', 9 => 'Sept', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'];

        $jemaatMeninggal = $jemaatMeninggal->map(function ($item) use ($monthNames) {
            $item->bulan = $monthNames[$item->bulan];
            return $item;
        });
        $baptisAnak = $baptisAnak->map(function ($item) use ($monthNames) {
            $item->bulan = $monthNames[$item->bulan];
            return $item;
        });

        $dropWilayah = Wilayah::pluck('nama_wilayah', 'id_wilayah');
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
        $labelPendidikan = $pendidikan->pluck('tingkatan');
        $data = [
            'widget' => $widget,
            'jumlahJemaat' => $jumlahJemaat->toArray(),
            'jemaatMeninggal' => $jemaatMeninggal->toArray(),
            'baptisAnak' => $baptisAnak->toArray(),
            'baptisSidi' => $baptisSidi->toArray(),
            'baptisDewasa' => $baptisDewasa->toArray(),
            'atestasiMasuk' => $atestasiMasuk->toArray(),
            'atestasiKeluar' => $atestasiKeluar->toArray(),
            'pendidikan' => $pendidikan->toArray(),
        ];
        return view('admin-wilayah.dashboard', compact('tahun', 'dropWilayah', 'labelWilayah', 'isiJemaat', 'labelBulan', 'isiKematian', 'labelBaptis', 'isiBA', 'isiBS', 'isiBD', 'isiMasuk', 'isiKeluar', 'isiPendidikan', 'labelPendidikan', 'wilayah'), $data);
    }

    public function adminWilayahDataAnggotaJemaat()
    {
        return view('admin-wilayah.data.anggota-jemaat');
    }

    public function adminWilayahDataAnggotaJemaatKeluarga()
    {
        return view('admin-wilayah.data.anggota-jemaat-keluarga');
    }
}
