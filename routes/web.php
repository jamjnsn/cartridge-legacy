<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
	Route::get('/files/{id}/{filename}', [App\Http\Controllers\FileController::class, 'download'])->name('download');
});

Route::prefix('admin')->group(function () {
	Route::view('/', 'admin.dashboard');

	Route::resource('users', App\Http\Controllers\Admin\UsersController::class);
	Route::resource('platforms', App\Http\Controllers\Admin\PlatformsController::class);
});
