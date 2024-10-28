<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ApiOutsideController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomLoginController;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// GET
    //Pengaturan
Route::post('/get/wilayah', [ApiController::class, 'ApiGetWilayah'])-> name('api.get.wilayah');
Route::post('/get/jabatan-majelis', [ApiController::class, 'ApiGetJabatanMajelis'])-> name('api.get.jabatan-majelis');
Route::post('/get/jabatan-non-majelis', [ApiController::class, 'ApiGetJabatanNonMajelis'])-> name('api.get.jabatan-non-majelis');
Route::post('/get/user', [ApiController::class, 'ApiGetUser'])-> name('api.get.user-admin');
Route::post('/get/role', [ApiController::class, 'ApiGetRole'])-> name('api.get.roles');
Route::post('/get/pekerjaan', [ApiController::class, 'ApiGetPekerjaan'])-> name('api.get.pekerjaan');
Route::post('/get/provinsi', [ApiController::class, 'ApiGetDaerahProvinsi'])-> name('api.get.provinsi');
Route::post('/get/kabupaten', [ApiController::class, 'ApiGetDaerahKabupaten'])-> name('api.get.kabupaten');
Route::post('/get/kecamatan', [ApiController::class, 'ApiGetDaerahKecamatan'])-> name('api.get.kecamatan');
Route::post('/get/kelurahan', [ApiController::class, 'ApiGetDaerahKelurahan'])-> name('api.get.kelurahan');
//daerah
    //Data
Route::post('/get/jemaat', [ApiController::class, 'ApiGetJemaat'])-> name('api.get.jemaat');
Route::post('/get/keluarga', [ApiController::class, 'ApiGetKeluarga'])-> name('api.get.keluarga');
Route::post('/get/anggotakeluarga', [ApiController::class, 'ApiGetAnggotaKeluarga'])-> name('api.get.anggotakeluarga');
Route::post('/get/majelis', [ApiController::class, 'ApiGetMajelis'])-> name('api.get.majelis');
Route::post('/get/nonmajelis', [ApiController::class, 'ApiGetNonMajelis'])-> name('api.get.nonmajelis');
Route::post('/get/pendeta' , [ApiController::class, 'ApiGetPendeta'])-> name('api.get.pendeta');
Route::post('/get/geeja', [ApiController::class, 'ApiGetGereja'])-> name('api.get.gereja');
    // Transaksi
Route::post('/get/pernikahan', [ApiController::class, 'ApiGetPernikahan'])-> name('api.get.pernikahan');
Route::post('/get/kematian', [ApiController::class, 'ApiGetKematian'])-> name('api.get.kematian');
Route::post('/get/atestasikeluar', [ApiController::class, 'ApiGetAtestasiKeluar'])-> name('api.get.atestasikeluar');
Route::post('/get/atestasimasuk', [ApiController::class, 'ApiGetAtestasiMasuk'])-> name('api.get.atestasimasuk');
Route::post('/get/baptisanak', [ApiController::class, 'ApiGetbaptisAnak'])-> name('api.get.baptisanak');
Route::post('/get/baptisdewasa', [ApiController::class, 'ApiGetbaptisDewasa'])-> name('api.get.baptisdewasa');
Route::post('/get/baptissidi', [ApiController::class, 'ApiGetbaptisSidi'])-> name('api.get.baptissidi');
    // Detail
Route::post('/get/jemaat/{id_jemaat}', [ApiController::class, 'ApiGetJemaatById'])->name('api.get.jemaat.by.id');

// POST
    //Pengaturan
Route::post('/post/wilayah', [ApiController::class, 'ApiPostWilayah'])-> name('api.post.wilayah');
Route::post('/post/jabatan-majelis', [ApiController::class, 'ApiPostJabatanMajelis'])-> name('api.post.jabatan-majelis');
Route::post('/post/jabatan-non-majelis', [ApiController::class, 'ApiPostJabatanNonMajelis'])-> name('api.post.jabatan-non-majelis');
Route::post('/post/user', [ApiController::class, 'ApiPostUser'])-> name('api.post.user');
Route::post('/post/pekerjaan', [ApiController::class, 'ApiPostPekerjaan'])-> name('api.post.pekerjaan');
Route::post('/post/provinsi', [ApiController::class, 'ApiPostProvinsi'])-> name('api.post.provinsi');
Route::post('/post/kabupaten', [ApiController::class, 'ApiPostKabupaten'])-> name('api.post.kabupaten');
Route::post('/post/kecamatan', [ApiController::class, 'ApiPostKecamatan'])-> name('api.post.kecamatan');
Route::post('/post/kelurahan', [ApiController::class, 'ApiPostKelurahan'])-> name('api.post.kelurahan');
    //Data
Route::post('/post/jemaat', [ApiController::class, 'ApiPostJemaat'])-> name('api.post.jemaat');
Route::post('/post/keluarga', [ApiController::class, 'ApiPostKeluarga'])-> name('api.post.keluarga');
Route::post('/post/majelis', [ApiController::class, 'ApiPostMajelis'])-> name('api.post.majelis');
Route::post('/post/nonmajelis', [ApiController::class, 'ApiPostNonMajelis'])-> name('api.post.nonmajelis');
Route::post('/post/pendeta', [ApiController::class, 'ApiPostPendeta'])-> name('api.post.pendeta');
    // Transaksi
Route::post('/post/pernikahan', [ApiController::class, 'ApiPostPernikahan'])-> name('api.post.pernikahan');
Route::post('/post/kematian', [ApiController::class, 'ApiPostKematian'])-> name('api.post.kematian');
Route::post('/post/atestasikeluar', [ApiController::class, 'ApiPostAtestasiKeluar'])-> name('api.post.atestasikeluar');
Route::post('/post/atestasimasuk', [ApiController::class, 'ApiPostAtestasiMasuk'])-> name('api.post.atestasimasuk');
Route::post('/post/baptisanak', [ApiController::class, 'ApiPostbaptisAnak'])-> name('api.post.baptisanak');
Route::post('/post/baptisdewasa', [ApiController::class, 'ApiPostbaptisDewasa'])-> name('api.post.baptisdewasa');
Route::post('/post/baptissidi', [ApiController::class, 'ApiPostbaptisSidi'])-> name('api.post.baptissidi');

// UPDATE
    //Pengaturan
Route::post('/update/wilayah', [ApiController::class, 'ApiUpdateWilayah'])-> name('api.update.wilayah');
Route::post('/update/jabatan-majelis', [ApiController::class, 'ApiUpdateJabatanMajelis'])-> name('api.update.jabatan-majelis');
Route::post('/update/jabatan-non-majelis', [ApiController::class, 'ApiUpdateJabatanNonMajelis'])-> name('api.update.jabatan-non-majelis');
Route::post('/update/user', [ApiController::class, 'ApiUpdateUser'])-> name('api.update.user');
Route::post('/update/pekerjaan', [ApiController::class, 'ApiUpdatePekerjaan'])-> name('api.update.pekerjaan');
//daerah
    //Data
Route::post('/update/jemaat', [ApiController::class, 'ApiUpdateJemaat'])-> name('api.update.jemaat');
Route::post('/update/keluarga', [ApiController::class, 'ApiUpdateKeluarga'])-> name('api.update.keluarga');
Route::post('/update/majelis', [ApiController::class, 'ApiUpdateMajelis'])-> name('api.update.majelis');
Route::post('/update/nonmajelis', [ApiController::class, 'ApiUpdateNonMajelis'])-> name('api.update.nonmajelis');
Route::post('/update/pendeta', [ApiController::class, 'ApiUpdatePendeta'])-> name('api.update.pendeta');
    // Transaksi
Route::post('/update/pernikahan', [ApiController::class, 'ApiUpdatePernikahan'])-> name('api.update.pernikahan');
Route::post('/update/kematian', [ApiController::class, 'ApiUpdateKematian'])-> name('api.update.kematian');
Route::post('/update/atestasikeluar', [ApiController::class, 'ApiUpdateAtestasiKeluar'])-> name('api.update.atestasikeluar');
Route::post('/update/atestasimasuk', [ApiController::class, 'ApiUpdateAtestasiMasuk'])-> name('api.update.atestasimasuk');
Route::post('/update/baptisanak', [ApiController::class, 'ApiUpdatebaptisAnak'])-> name('api.update.baptisanak');
Route::post('/update/baptisdewasa', [ApiController::class, 'ApiUpdatebaptisDewasa'])-> name('api.update.baptisdewasa');
Route::post('/update/baptissidi', [ApiController::class, 'ApiUpdatebaptisSidi'])-> name('api.update.baptissidi');

// DELETE
    //Pengaturan
Route::post('/delete/wilayah', [ApiController::class, 'ApiDeleteWilayah'])-> name('api.delete.wilayah');
Route::post('/delete/jabatan-majelis', [ApiController::class, 'ApiDeleteJabatanMajelis'])-> name('api.delete.jabatan-majelis');
Route::post('/delete/jabatan-non-majelis', [ApiController::class, 'ApiDeleteJabatanNonMajelis'])-> name('api.delete.jabatan-non-majelis');
Route::post('/delete/user', [ApiController::class, 'ApiDeleteUser'])-> name('api.delete.user');
Route::post('/delete/pekerjaan', [ApiController::class, 'ApiDeletePekerjaan'])-> name('api.delete.pekerjaan');
Route::post('/delete/provinsi', [ApiController::class, 'ApiDeleteProvinsi'])-> name('api.delete.provinsi');
Route::post('/delete/kabupaten', [ApiController::class, 'ApiDeleteKabupaten'])-> name('api.delete.kabupaten');
Route::post('/delete/kecamatan', [ApiController::class, 'ApiDeleteKecamatan'])-> name('api.delete.kecamatan');
Route::post('/delete/kelurahan', [ApiController::class, 'ApiDeleteKelurahan'])-> name('api.delete.kelurahan');
//daerah
    //Data
Route::post('/delete/jemaat', [ApiController::class, 'ApiDeleteJemaat'])-> name('api.delete.jemaat');
Route::post('/delete/keluarga', [ApiController::class, 'ApiDeleteKeluarga'])-> name('api.delete.keluarga');
Route::post('/delete/majelis', [ApiController::class, 'ApiDeleteMajelis'])-> name('api.delete.majelis');
Route::post('/delete/nonmajelis', [ApiController::class, 'ApiDeleteNonMajelis'])-> name('api.delete.nonmajelis');
Route::post('/delete/pendeta', [ApiController::class, 'ApiDeletePendeta'])-> name('api.delete.pendeta');
    // Transaksi
Route::post('/delete/pernikahan', [ApiController::class, 'ApiDeletePernikahan'])-> name('api.delete.pernikahan');
Route::post('/delete/kematian', [ApiController::class, 'ApiDeleteKematian'])-> name('api.delete.kematian');
Route::post('/delete/atestasikeluar', [ApiController::class, 'ApiDeleteAtestasiKeluar'])-> name('api.delete.atestasikeluar');
Route::post('/delete/atestasimasuk', [ApiController::class, 'ApiDeleteAtestasiMasuk'])-> name('api.delete.atestasimasuk');
Route::post('/delete/baptisanak', [ApiController::class, 'ApiDeletebaptisAnak'])-> name('api.delete.baptisanak');
Route::post('/delete/baptisdewasa', [ApiController::class, 'ApiDeletebaptisDewasa'])-> name('api.delete.baptisdewasa');
Route::post('/delete/baptissidi', [ApiController::class, 'ApiDeletebaptisSidi'])-> name('api.delete.baptissidi');

// API Outside
Route::post('/proxy-wilayah', [ApiOutsideController::class, 'ApiOutsideGetWilayah'])->name('api.proxy.wilayah');
