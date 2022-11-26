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


// Removed 'auth.sanctum' for testing the performance testing
Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => []], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Kependudukan
    Route::apiResource('kependudukans', 'KependudukanApiController');

    // Entry Mail
    Route::post('entry-mails/media', 'EntryMailApiController@storeMedia')->name('entry-mails.storeMedia');
    Route::apiResource('entry-mails', 'EntryMailApiController');

    // Berita
    Route::post('berita/media', 'BeritaApiController@storeMedia')->name('berita.storeMedia');
    Route::apiResource('berita', 'BeritaApiController');

    // Pengumuman
    Route::post('pengumumen/media', 'PengumumanApiController@storeMedia')->name('pengumumen.storeMedia');
    Route::apiResource('pengumumen', 'PengumumanApiController');

    // Rule
    Route::apiResource('rules', 'RuleApiController');
});
