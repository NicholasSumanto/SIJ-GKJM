<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomLoginController;

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

// Get
Route::post('/get/wilayah', [ApiController::class, 'ApiGetWilayah'])-> name('api.get.wilayah');
Route::post('/get/jabatan-majelis', [ApiController::class, 'ApiGetJabatanMajelis'])-> name('api.get.jabatan-majelis');
Route::post('/get/jabatan-non-majelis', [ApiController::class, 'ApiGetJabatanNonMajelis'])-> name('api.get.jabatan-non-majelis');

// Post
Route::post('/post/wilayah', [ApiController::class, 'ApiPostWilayah'])-> name('api.post.wilayah');
Route::post('/post/jabatan-majelis', [ApiController::class, 'ApiPostJabatanMajelis'])-> name('api.post.jabatan-majelis');
Route::post('/post/jabatan-non-majelis', [ApiController::class, 'ApiPostJabatanNonMajelis'])-> name('api.post.jabatan-non-majelis');

// Update
Route::post('/update/wilayah', [ApiController::class, 'ApiUpdateWilayah'])-> name('api.update.wilayah');
Route::post('/update/jabatan-majelis', [ApiController::class, 'ApiUpdateJabatanMajelis'])-> name('api.update.jabatan-majelis');
Route::post('/update/jabatan-non-majelis', [ApiController::class, 'ApiUpdateJabatanNonMajelis'])-> name('api.update.jabatan-non-majelis');

// Delete
Route::post('/delete/wilayah', [ApiController::class, 'ApiDeleteWilayah'])-> name('api.delete.wilayah');
Route::post('/delete/jabatan-majelis', [ApiController::class, 'ApiDeleteJabatanMajelis'])-> name('api.delete.jabatan-majelis');
Route::post('/delete/jabatan-non-majelis', [ApiController::class, 'ApiDeleteJabatanNonMajelis'])-> name('api.delete.jabatan-non-majelis');
