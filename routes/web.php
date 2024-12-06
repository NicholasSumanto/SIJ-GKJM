<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BasicController;
use App\Http\Controllers\AdminPageController;
use App\Http\Controllers\AdminWilayahPageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BirthdayController;
use App\Http\Controllers\UsiaController;
use App\Http\Controllers\CustomLoginController;
use App\Http\Controllers\GeoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('landing');

// Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::middleware('auth:admin')->group(function () {
    // Admin Routes Start
    Route::get('/admin/dashboard', AdminPageController::class . '@adminDashboard')->name('admin.dashboard');
    Route::get('/admin/BirthdayDashboard', BirthdayController::class . '@birthdayDashboard')->name('admin.birthdayDash');
    Route::get('/admin/dashboardUsia', UsiaController::class . '@usiaDashboard')->name('admin.dashboardUsia');
    // Pengaturan Routes
    Route::get('/admin/pengaturan/wilayah', AdminPageController::class . '@adminPengaturanWilayah')->name('admin.pengaturan.wilayah');
    Route::get('/admin/pengaturan/jabatan-majelis', AdminPageController::class . '@adminPengaturanJabatanMajelis')->name('admin.pengaturan.jabatan-majelis');
    Route::get('/admin/pengaturan/jabatan-non-majelis', AdminPageController::class . '@adminPengaturanJabatanNonMajelis')->name('admin.pengaturan.jabatan-non-majelis');
    Route::get('/admin/pengaturan/user-admin', AdminPageController::class . '@adminPengaturanUserAdmin')->name('admin.pengaturan.user-admin');
    // Route::get('/admin/pengaturan/referensi-pekerjaan', AdminPageController::class . '@adminReferensiPekerjaan')->name('admin.pengaturan.referensi-pekerjaan');
    Route::get('/admin/pengaturan/referensi-daerah/provinsi', AdminPageController::class . '@adminReferensiDaerah')->name('admin.pengaturan.referensi-daerah');
    Route::get('/admin/pengaturan/referensi-daerah/kabupaten/{id_provinsi}', AdminPageController::class . '@adminReferensiDaerahKabupaten')->name('admin.pengaturan.referensi-daerah-kabupaten');
    Route::get('/admin/pengaturan/referensi-daerah/kecamatan/{id_kabupaten}', AdminPageController::class . '@adminReferensiDaerahKecamatan')->name('admin.pengaturan.referensi-daerah-kecamatan');
    Route::get('/admin/pengaturan/referensi-daerah/kelurahan/{id_kecamatan}', AdminPageController::class . '@adminReferensiDaerahKelurahan')->name('admin.pengaturan.referensi-daerah-kelurahan');
    // Data
    Route::get('/admin/data/anggota-jemaat', AdminPageController::class . '@adminDataAnggotaJemaat')->name('admin.data.anggota-jemaat');
    Route::get('/admin/data/anggota-jemaat/{id}', AdminPageController::class . '@adminDataAnggotaJemaatDetail')->name('admin.data.anggota-jemaat-keluarga-detail');
    Route::get('/admin/data/jemaat-baru/{id}', AdminPageController::class . '@adminDataAnggotaJemaatBaruDetail')->name('admin.data.anggota-jemaat-baru-keluarga-detail');
    Route::get('/admin/data/anggota-jemaat-keluarga', AdminPageController::class . '@adminDataAnggotaJemaatKeluarga')->name('admin.data.anggota-jemaat-keluarga');
    Route::get('/admin/data/jemaat-titipan', AdminPageController::class . '@adminDataJemaatTitipan')->name('admin.data.jemaat-titipan');
    Route::get('/admin/data/jemaat-baru', AdminPageController::class . '@adminDataJemaatBaru')->name('admin.data.jemaat-baru');
    Route::get('/admin/data/pendeta', AdminPageController::class . '@adminDataPendeta')->name('admin.data.pendeta');
    Route::get('/admin/data/majelis', AdminPageController::class . '@adminDataMajelis')->name('admin.data.majelis');
    Route::get('/admin/data/non-majelis', AdminPageController::class . '@adminDataNonMajelis')->name('admin.data.non-majelis');
    Route::get('/admin/data/jemaat-titipan', AdminPageController::class . '@adminDataJemaatTitipan')->name('admin.data.jemaat-titipan');
    Route::get('/admin/data/jemaat-ultah', AdminPageController::class . '@adminDataJemaatUltah')->name('admin.data.jemaat-ultah');
    Route::get('/admin/data/jemaat-ultah-nikah', AdminPageController::class . '@adminDataJemaatUltahNikah')->name('admin.data.jemaat-ultah-nikah');
    // Transaksi
    Route::get('/admin/transaksi/pernikahan', AdminPageController::class . '@adminTransaksiPernikahan')->name('admin.transaksi.pernikahan');
    Route::get('/admin/transaksi/kematian', AdminPageController::class . '@adminTransaksiKematian')->name('admin.transaksi.kematian');
    Route::get('/admin/transaksi/atestasi-keluar', AdminPageController::class . '@adminTransaksiAtestasiKeluar')->name('admin.transaksi.atestasi-keluar');
    Route::get('/admin/transaksi/atestasi-keluar/{id}', AdminPageController::class . '@adminTransaksiAtestasiKeluarDetail')->name('admin.transaksi.atestasi-keluar-detail');
    Route::get('/admin/transaksi/atestasi-masuk', AdminPageController::class . '@adminTransaksiAtestasiMasuk')->name('admin.transaksi.atestasi-masuk');
    Route::get('/admin/transaksi/baptis-anak', AdminPageController::class . '@adminTransaksiBaptisAnak')->name('admin.transaksi.baptis-anak');
    Route::get('/admin/transaksi/baptis-dewasa', AdminPageController::class . '@adminTransaksiBaptisDewasa')->name('admin.transaksi.baptis-dewasa');
    Route::get('/admin/transaksi/baptis-sidi', AdminPageController::class . '@adminTransaksiBaptisSidi')->name('admin.transaksi.baptis-sidi');
    // Admin Routes End
});

Route::middleware('auth:adminWilayah')->group(function () {
    Route::get('/admin-wilayah/dashboard', action: AdminWilayahPageController::class . '@adminWilayahDashboard')->name('admin-wilayah.dashboard');
    Route::get('/admin-wilayah/data/anggota-jemaat', action: AdminWilayahPageController::class . '@adminWilayahDataAnggotaJemaat')->name('admin-wilayah.data.anggota-jemaat');
    Route::get('/admin-wilayah/data/anggota-jemaat/{id}/{validasi}', AdminWilayahPageController::class . '@adminWilayahDataAnggotaJemaatDetail')->name('admin-wilayah.data.anggota-jemaat-keluarga-detail');
    Route::get('/admin-wilayah/data/anggota-jemaat-keluarga', action: AdminWilayahPageController::class . '@adminWilayahDataAnggotaJemaatKeluarga')->name('admin-wilayah.data.anggota-jemaat-keluarga');
});

// Route::middleware(['auth:admin', 'auth:adminWilayah'])->group(function () {
    Route::post('/logout', AuthController::class.'@logout')->name('logout');
    // Route::get('/logout', AuthController::class.'@logout')->name('logout');
// });

// Route::middleware('guest')->group(function () {
    Route::get('/login', AuthController::class.'@showLoginForm')->name('login');
    Route::post('/login', AuthController::class.'@login')->name('api.post.login');
// });

Route::middleware('auth')->group(function () {
    Route::resource('basic', BasicController::class);
});
