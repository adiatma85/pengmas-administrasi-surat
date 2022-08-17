<?php

use Illuminate\Support\Facades\Route;

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

// Controller Import
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\PermissionsController as AdminPermissionController;
use App\Http\Controllers\Admin\RolesController as AdminRolesController;
use App\Http\Controllers\Admin\UsersController as AdminUsersController;
use App\Http\Controllers\Admin\KependudukanController as AdminKependudukanController;


Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::prefix("admin")->as("admin.")->middleware('auth')->group(function (){
    Route::get('/', [AdminHomeController::class, 'index'])->name('home');    

    // Permissions
    Route::delete('permissions/destroy', [AdminPermissionController::class, 'massDestroy'])->name('permissions.massDestroy');
    Route::resource('permissions', AdminPermissionController::class);

    // Roles
    Route::delete('roles/destroy', [AdminRolesController::class, 'massDestroy'])->name('roles.massDestroy');
    Route::resource('roles', AdminRolesController::class);

    // Users
    Route::delete('users/destroy', [AdminUsersController::class, 'massDestroy'])->name('users.massDestroy');
    Route::resource('users', AdminUsersController::class);

     // Kependudukan
     Route::delete('kependudukans/destroy', [AdminKependudukanController::class, 'massDestroy'])->name('kependudukans.massDestroy');
     Route::resource('kependudukans', AdminKependudukanController::class);
});

Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});