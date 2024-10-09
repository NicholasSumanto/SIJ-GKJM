<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Jemaat;
use App\Models\Kematian;
use App\Models\BaptisDewasa;
use App\Models\BaptisSidi;
use App\Models\BaptisAnak;
use App\Models\AtestasiKeluar;
use App\Models\AtestasiMasuk;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
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
    public function index(Request $request)
    {
        $users = User::count();

        $widget = [
            'users' => $users,
            //...
        ];
        $gender = $request->input('Kelamin');
        $jumlahJemaat = Jemaat::selectRaw('id_wilayah, COUNT(*) as jumlah')
            ->when($gender, function ($query, $gender) {
                return $query->where('Kelamin', $gender); 
            })
            ->groupBy('id_wilayah')
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
        $atestasiKeluar = AtestasiKeluar::selectRaw('MONTH(tanggal) as bulan, COUNT(*) as jumlah')
            ->join('jemaat', 'atestasi_keluar.id_jemaat', '=', 'jemaat.id_jemaat')
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender); 
            })
            ->groupBy('bulan')
            ->get();
        $pendidikan = Jemaat::selectRaw('pendidikan.pendidikan as tingkatan, COUNT(*) as jumlah')
            ->join('pendidikan', 'pendidikan.id_pendidikan', '=', 'jemaat.id_pendidikan')
            ->when($gender, function ($query, $gender) {
                return $query->where('jemaat.kelamin', $gender); 
            })
            ->groupBy('tingkatan')
            ->get();

        $labelJemaat = $jumlahJemaat->pluck('id_wilayah');  
        $isiJemaat = $jumlahJemaat->pluck('jumlah');
        $labelBulan = $jemaatMeninggal->pluck('bulan');  
        $isiKematian = $jemaatMeninggal->pluck('jumlah');
        $isiBA = $baptisAnak->pluck('total');
        $isiBS = $baptisSidi->pluck('total');
        $isiBD = $baptisDewasa->pluck('total');
        $labelBaptis = $baptisAnak->pluck('bulan');
        $isiMasuk = $atestasiMasuk->pluck('jumlah');
        $isiKeluar = $atestasiKeluar->pluck('jumlah');; 
        $pendidikan = $pendidikan->pluck('jumlah');
        $labelPendidikan =$pendidikan->pluck('tingkatan');
        // Pass the filtered data to your view
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
        ];
        return view('home',compact('labelJemaat','isiJemaat','labelBulan','isiKematian','labelBaptis','isiBA','isiBS','isiBD','isiMasuk','isiKeluar','pendidikan'), $data);
    }
}
