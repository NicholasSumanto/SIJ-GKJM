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

class UsiaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // admin
    public function usiaDashboard(Request $request)
    {
        $users = User::count();

        $widget = [
            'users' => $users,
        ];

        $cutoffDate = Carbon::now()->subYears(17)->toDateString();
        $totalJemaat = Jemaat::count();
        $rataRataUsia = Jemaat::avg(DB::raw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE())'));
        $termuda = Jemaat::min(DB::raw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE())'));
        $tertua = Jemaat::max(DB::raw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE())'));
        $jumlahAnak = Jemaat::where('tanggal_lahir','<', $cutoffDate)->count();
        $jumlahDewasa = Jemaat::where('tanggal_lahir', '>=', $cutoffDate)->count();
        $ageGroups = Jemaat::select(
            DB::raw('
                CASE
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) < 7 THEN "<6th"
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 7 AND 15 THEN "7-15th"
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 16 AND 18 THEN "16-18th"
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 19 AND 30 THEN "19-30th"
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 31 AND 39 THEN "30-39th"
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 40 AND 59 THEN "40-59th"
                    ELSE ">60th"
                END as age_group
            '),
            DB::raw('COUNT(*) as total')
            )
            ->groupBy('age_group')
            ->pluck('total', 'age_group')->toArray();
// dd($ageGroups);
        $wilayahData = Jemaat::select(
                'wilayah.nama_wilayah',
                DB::raw('SUM(CASE WHEN jemaat.tanggal_lahir > "' . $cutoffDate . '" THEN 1 ELSE 0 END) AS anak_count'),
                DB::raw('SUM(CASE WHEN jemaat.tanggal_lahir <= "' . $cutoffDate . '" THEN 1 ELSE 0 END) AS dewasa_count')
            )
            ->join('wilayah', 'jemaat.id_wilayah', '=', 'wilayah.id_wilayah')
            ->groupBy('wilayah.nama_wilayah')
            ->orderBy('wilayah.nama_wilayah')
            ->get();

        $labels = array_keys($ageGroups);
        $data = array_values($ageGroups);
        $wilayahLabels = $wilayahData->pluck('nama_wilayah')->toArray();
        $anakCounts = $wilayahData->pluck('anak_count')->toArray();
        $dewasaCounts = $wilayahData->pluck('dewasa_count')->toArray();

        return view('admin.dashboardUsia',compact('wilayahLabels', 'anakCounts', 'dewasaCounts','labels','data','totalJemaat', 'rataRataUsia', 'termuda', 'tertua', 'jumlahAnak', 'jumlahDewasa'));
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

    public function birthdayDashboard()
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
