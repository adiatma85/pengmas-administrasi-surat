<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Controller Import (User)
use App\Http\Controllers\Api\V1\User\AuthApiController as ApiAuthController;
use App\Http\Controllers\Api\V1\User\BeritaApiController as ApiUserBeritaController;
use App\Http\Controllers\Api\V1\User\PengumumanApiController as ApiUserPengumumanController;
use App\Http\Controllers\Api\V1\User\RuleApiController as ApiUserPeraturanController;
use App\Http\Controllers\Api\V1\User\GeneratePdfApiController as ApiUserGeneratePdf;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->as('v1.')->group(function (){

    // Login
    Route::post('/auth/login', [ApiAuthController::class, 'login']);

    // Berita
    Route::apiResource('berita', ApiUserBeritaController::class);

    // Pengumuman
    Route::apiResource('pengumuman', ApiUserPengumumanController::class);

    // Peraturan
    Route::apiResource('peraturan', ApiUserPeraturanController::class);

    // Group with sanctum
    Route::middleware('auth:sanctum')->group(function () {
        // Generate Surat Domisili
        Route::post('/generate/surat-domisili', [ApiUserGeneratePdf::class, 'generateSuratDomisili']);

        // Generate Surat Pengantar Nikah
        Route::post('/generate/surat-pengantar-nikah', [ApiUserGeneratePdf::class, 'generateSuratPengantarNikah']);

        // Generate Surat Keterangan Belum Menikah
        Route::post('/generate/surat-keterangan-belum-nikah', [ApiUserGeneratePdf::class, 'generateSuratKeteranganBelumMenikah']);

        // Generate Surat Persetujuan Tetangga
        Route::post('/generate/surat-persetujuan-tetangga', [ApiUserGeneratePdf::class, 'generateSuratPersetujuanTetangga']);
    });
});