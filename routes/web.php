<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BasicController;
use App\Http\Controllers\AdminPageController;
use App\Http\Controllers\CustomLoginController;

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
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');

Route::get('/about', function () {
    return view('about');
})->name('about');

// Admin Routes Start
Route::get('/admin/dashboard', AdminPageController::class . '@adminDashboard')->name('admin.dashboard');
// Pengaturan Routes
Route::get('/admin/pengaturan/wilayah', AdminPageController::class . '@adminPengaturanWilayah')->name('admin.pengaturan.wilayah');
Route::get('/admin/pengaturan/jabatan-majelis', AdminPageController::class . '@adminPengaturanJabatanMajelis')->name('admin.pengaturan.jabatan-majelis');
Route::get('/admin/pengaturan/jabatan-non-majelis', AdminPageController::class . '@adminPengaturanJabatanNonMajelis')->name('admin.pengaturan.jabatan-non-majelis');
Route::get('/admin/pengaturan/user-admin', AdminPageController::class . '@adminPengaturanUserAdmin')->name('admin.pengaturan.user-admin');
Route::get('/admin/pengaturan/referensi-pekerjaan', AdminPageController::class . '@adminReferensiPekerjaan')->name('admin.pengaturan.referensi-pekerjaan');
Route::get('/admin/pengaturan/referensi-daerah', AdminPageController::class . '@adminReferensiDaerah')->name('admin.pengaturan.referensi-daerah');
// Data
Route::get('/admin/data/anggota-jemaat', AdminPageController::class . '@adminDataAnggotaJemaat')->name('admin.data.anggota-jemaat');
Route::get('/admin/data/anggota-jemaat-keluarga', AdminPageController::class . '@adminDataAnggotaJemaatKeluarga')->name('admin.data.anggota-jemaat-keluarga');
Route::get('/admin/data/jemaat-baru', AdminPageController::class . '@adminDataJemaatBaru')->name('admin.data.jemaat-baru');
Route::get('/admin/data/majelis', AdminPageController::class . '@adminDataMajelis')->name('admin.data.majelis');
Route::get('/admin/data/non-majelis', AdminPageController::class . '@adminDataNonMajelis')->name('admin.data.non-majelis');
Route::get('/admin/data/jemaat-titipan', AdminPageController::class . '@adminDataJemaatTitipan')->name('admin.data.jemaat-titipan');
Route::get('/admin/data/jemaat-ultah', AdminPageController::class . '@adminDataJemaatUltah')->name('admin.data.jemaat-ultah');
Route::get('/admin/data/jemaat-ultah-nikah', AdminPageController::class . '@adminDataJemaatUltahNikah')->name('admin.data.jemaat-ultah-nikah');
// Transaksi
Route::get('/admin/transaksi/pernikahan', AdminPageController::class . '@adminTransaksiPernikahan')->name('admin.transaksi.pernikahan');
Route::get('/admin/transaksi/kematian', AdminPageController::class . '@adminTransaksiKematian')->name('admin.transaksi.kematian');
Route::get('/admin/transaksi/atestasi-keluar', AdminPageController::class . '@adminTransaksiAtestasiKeluar')->name('admin.transaksi.atestasi-keluar');
Route::get('/admin/transaksi/atestasi-masuk', AdminPageController::class . '@adminTransaksiAtestasiMasuk')->name('admin.transaksi.atestasi-masuk');
Route::get('/admin/transaksi/baptis-anak', AdminPageController::class . '@adminTransaksiBaptisAnak')->name('admin.transaksi.baptis-anak');
Route::get('/admin/transaksi/baptis-dewasa', AdminPageController::class . '@adminTransaksiBaptisDewasa')->name('admin.transaksi.baptis-dewasa');
Route::get('/admin/transaksi/baptis-sidi', AdminPageController::class . '@adminTransaksiBaptisSidi')->name('admin.transaksi.baptis-sidi');
// Admin Routes End

// API
// Route::post('/login', CustomLoginController::class.'@login')->name('api.post.login');

Route::middleware('auth')->group(function() {
    Route::resource('basic', BasicController::class);
});
