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

// Controller Import (Admin)
use App\Http\Controllers\Api\V1\Admin\PermissionsApiController as ApiAdminPermissionController;
use App\Http\Controllers\Api\V1\Admin\RolesApiController as ApiAdminRoleController;
use App\Http\Controllers\Api\V1\Admin\BeritaApiController as ApiAdminBeritaController;
use App\Http\Controllers\Api\V1\Admin\UsersApiController as ApiAdminUserController;
use App\Http\Controllers\Api\V1\Admin\KependudukanApiController as ApiAdminKependudukanController;
use App\Http\Controllers\Api\V1\Admin\EntryMailApiController as ApiAdminEntryMailController;
use App\Http\Controllers\Api\V1\Admin\PengumumanApiController as ApiAdminPengumumanController;
use App\Http\Controllers\Api\V1\Admin\RuleApiController as ApiAdminRuleController;



// Removed 'auth.sanctum' for testing the performance testing
Route::prefix('v1')->group(function (){
    // Permissions
    Route::apiResource('permissions', ApiAdminPermissionController::class);

    // Roles
    Route::apiResource('roles', ApiAdminRoleController::class);

    // Users
    Route::apiResource('users', ApiAdminUserController::class);

    // Kependudukan
    Route::apiResource('kependudukans', ApiAdminKependudukanController::class);

    // Entry Mail
    Route::apiResource('entry-mails', ApiAdminEntryMailController::class);

    // Berita
    Route::apiResource('berita', ApiAdminBeritaController::class);

    // Pengumuman
    Route::apiResource('pengumuman', ApiAdminPengumumanController::class);

    // Rule
    Route::apiResource('rules', ApiAdminRuleController::class);
});
