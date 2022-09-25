<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// Controller Import (Admin)
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\PermissionsController as AdminPermissionController;
use App\Http\Controllers\Admin\RolesController as AdminRolesController;
use App\Http\Controllers\Admin\UsersController as AdminUsersController;
use App\Http\Controllers\Admin\KependudukanController as AdminKependudukanController;
use App\Http\Controllers\Admin\EntryMailController as AdminEntryMailController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\PengumumanController as AdminPengumumanController;

// Controller Import (Auth)
use App\Http\Controllers\Auth\ChangePasswordController as AuthChangePassworController;

// Controller Import (User)
use App\Http\Controllers\User\MailController as UserMailController;


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

    // Entry Mail
    Route::delete('entry-mails/destroy', [AdminEntryMailController::class, 'massDestroy'])->name('entry-mails.massDestroy');
    Route::post('entry-mails/media', [AdminEntryMailController::class, 'storeMedia'])->name('entry-mails.storeMedia');
    Route::post('entry-mails/ckmedia', [AdminEntryMailController::class, 'storeCKEditorImages'])->name('entry-mails.storeCKEditorImages');
    Route::post('entry-mails/accept/{entryMailId}', [AdminEntryMailController::class, 'mailAccept'])->name('entry-mails.mailAccept');
    Route::post('entry-mails/reject/{entryMailId}', [AdminEntryMailController::class, 'mailReject'])->name('entry-mails.mailReject');
    Route::resource('entry-mails', AdminEntryMailController::class);


    // Berita
    Route::delete('berita/destroy', [AdminBeritaController::class, 'massDestroy'])->name('berita.massDestroy');
    Route::post('berita/media', [AdminBeritaController::class, 'storeMedia'])->name('berita.storeMedia');
    Route::post('berita/ckmedia', [AdminBeritaController::class, 'storeCKEditorImages'])->name('berita.storeCKEditorImages');
    Route::resource('berita', AdminBeritaController::class);

    // Pengumuman
    Route::delete('pengumuman/destroy', [AdminPengumumanController::class, 'massDestroy'])->name('pengumuman.massDestroy');
    Route::post('pengumuman/media', [AdminPengumumanController::class, 'storeMedia'])->name('pengumuman.storeMedia');
    Route::post('pengumuman/ckmedia', [AdminPengumumanController::class, 'storeCKEditorImages'])->name('pengumuman.storeCKEditorImages');
    Route::resource('pengumuman', AdminPengumumanController::class);
});

// This is for user
Route::prefix("portal")->as("portal.")->middleware('auth')->group( function (){
    // Pengajuan Surat
    Route::resource('pengajuan-surat', UserMailController::class);
});

Route::prefix('profile')->as('profile.')->middleware('auth')->group( function(){
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', [AuthChangePassworController::class, 'edit'])->name('password.edit');
        Route::post('password', [AuthChangePassworController::class, 'update'])->name('password.update');
        Route::post('profile', [AuthChangePassworController::class, 'updateProfile'])->name('password.updateProfile');
        Route::post('profile/destroy', [AuthChangePassworController::class, 'destroy'])->name('password.destroyProfile');
    }
});