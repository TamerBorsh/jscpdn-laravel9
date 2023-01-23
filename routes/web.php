<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Circle\CircleController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Department\DepartmentController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Permission\PermissionController;
use App\Http\Controllers\Problem\ProblemController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Role\RolePermissionController;
use App\Http\Controllers\Treatment\TreatmentController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\UserController;
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

Route::get('artisan_db', function () {

    \Artisan::call('migrate:fresh --seed');
    \Artisan::call('passport:install');
    \Artisan::call('optimize:clear');

    dd("done");
});

define('page_numbering_back', "10");
Route::group(['prefix' => 'auth'], function () {

    Route::get('{guard}/login',     [LoginController::class, 'index'])->name('auth.login');
    Route::post('login',            [LoginController::class, 'authenticate'])->name('auth.authenticate');
    Route::get('logout',            [LoginController::class, 'logout'])->name('auth.logout');
});

Route::group(['prefix' => 'dashboard'], function () {

    //Dashboard
    Route::get('/',                                 [DashboardController::class, 'index'])->name('dashboard.index');

    Route::resource('admins',                       AdminController::class);


    Route::resource('users',                        UserController::class);
    Route::get('users/export/excel',                [UserController::class, 'ExportExcel'])->name('users.export.excel');
    Route::get('users/upload/excel',                [UserController::class, 'UploadExcel'])->name('users.upload.excel');
    Route::post('users-upload-import',              [UserController::class, 'ImportExcel'])->name('users.import.excel');
    Route::get('generate-pdf',                      [UserController::class, 'generatePDF'])->name('users.export.pdf');
    Route::get('generat',                           [UserController::class, 'generatePDF']);

    Route::get('user_profile',                      [ProfileController::class, 'get_profile'])->name('users.get_profile');
    Route::put('user_profile_store/{id}',           [ProfileController::class, 'update_profile'])->name('users.update_profile');

    Route::resource('problems',                     ProblemController::class);


    //roles
    Route::resource('roles',                    RoleController::class);
    Route::put('roles/{role}/permissions',      [RolePermissionController::class, 'update'])->name('RolePermission.update');
});
