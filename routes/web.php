<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserTypeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ImageProfileController;

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';


Route::middleware(['web', 'auth'])->group(function () {
    Route::middleware([\App\Http\Middleware\AuthGates::class])->group(function () {

        Route::get('/home', [HomeController::class, 'home'])->name('home');
        Route::fallback([SettingController::class, 'fallback']);
        Route::get('/error', [SettingController::class, 'error']);
        Route::get('/cache_clear', [SettingController::class, 'cache_clear']);
        Route::get('/config_clear', [SettingController::class, 'config_clear']);
        Route::get('/view_clear', [SettingController::class, 'view_clear']);
        Route::get('/route_clear', [SettingController::class, 'route_clear']);
        Route::get('/clear_all', [SettingController::class, 'clear_all']);
        Route::get('/storage_link', [SettingController::class, 'storage_link']);
        Route::get('/backupDatabase{code}', [SettingController::class, 'backupDatabase']);

        Route::get('lang/{lang}', [HomeController::class, 'switchLang'])->name('lang.switch');
        Route::get('dashboard', [HomeController::class, 'home'])->name('dashboard');
        Route::resource('permission', PermissionController::class);
        Route::resource('role', RoleController::class);
        Route::resource('user-type', UserTypeController::class);
        Route::resource('setting', SettingController::class);
        Route::post('/select_user_action', [UserController::class, 'select_user_action'])->name('select_user_action');
        Route::patch('/user/Auth::user()', [UserController::class, 'password_update'])->name('password_update');
        Route::get('/myprofile', [UserController::class, 'myprofile'])->name('myprofile');
        Route::resource('user', UserController::class);
        Route::resource('profile', ProfileController::class);
        Route::resource('imageprofile', ImageProfileController::class);

    });
});


