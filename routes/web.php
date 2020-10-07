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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function () {
    /**
     * Page Not Found
     */
    Route::get('blank-page', 'BlankPageController@index')->name('blank-page');

    /**
     * Master Roles
     */
    Route::prefix('master-roles')->namespace('MasterRole')->name('master-role.')->group(function () {
        // Role
        Route::resource('role', 'RoleController');
        Route::prefix('role')->name('role.')->group(function () {
            Route::post('api', 'RoleController@api')->name('api');
            Route::get('{id}/addPermissions', 'RoleController@permission')->name('addPermissions');
            Route::post('storePermissions', 'RoleController@storePermission')->name('storePermissions');
            Route::get('{id}/getPermissions', 'RoleController@getPermissions')->name('getPermissions');
            Route::delete('{name}/destroyPermission', 'RoleController@destroyPermission')->name('destroyPermission');
        });
        // Permission
        Route::resource('permission', 'PermissionController');
        Route::post('permission/api', 'PermissionController@api')->name('permission.api');
        // Pegawai
        Route::resource('pengguna', 'PenggunaController');
        Route::post('pengguna/api', 'PenggunaController@api')->name('pengguna.api');
        Route::get('pengguna/{id}/editPassword', 'PenggunaController@editPassword')->name('pengguna.editPassword');
        Route::post('pengguna/{id}/updatePassword', 'PenggunaController@updatePassword')->name('pengguna.updatePassword');
    });

    /**
     * Config Template
     */
    Route::prefix('config-templates')->namespace('ConfigTemplate')->name('config-template.')->group(function () {
        // Template
        Route::resource('template', 'TemplateController');
        Route::post('template/api', 'TemplateController@api')->name('template.api');
    });

    /**
     * Profile
     */
    Route::prefix('profile')->namespace('Profile')->name('master-profile.')->group(function () {
        // Profile
        Route::resource('profile', 'ProfileController');
        Route::get('profile/{id}/edtiPasswrod', 'ProfileController@editPassword')->name('profile.editPassword');
        Route::post('profile/{id}/updatePassword', 'ProfileController@updatePassword')->name('profile.updatePassword');
    });

    Route::prefix('MasterData')->namespace('BukuTamu')->name('master-data.')->group(function () {
        // Sudah Diambil
        Route::resource('sudah-diambil', 'SudahDiambilController');
        Route::post('sudah-diambil/api', 'SudahDiambilController@api')->name('sudah-diambil.api');
        // Belum Diambil
        Route::resource('belum-diambil', 'BelumDiambilController');
        Route::post('belum-diambil', 'BelumDiambilController@api')->name('belum-diambil.api');
        // Report
        Route::resource('report', 'ReportController');
        Route::post('report/api', 'ReportController@api')->name('report.api');
        Route::post('cetak', 'ReportController@print')->name('cetak');
    });
});
