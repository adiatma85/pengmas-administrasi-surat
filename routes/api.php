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
use App\Http\Controllers\Api\V1\User\BeritaApiController as ApiUserBeritaController;
use App\Http\Controllers\Api\V1\User\PengumumanApiController as ApiUserPengumumanController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->as('v1.')->group(function (){
    // Berita
    Route::apiResource('berita', ApiUserBeritaController::class);

    // Pengumuman
    Route::apiResource('pengumuman', ApiUserPengumumanController::class);

    // Peraturan
});