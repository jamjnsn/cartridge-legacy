<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
	Route::get('/files/{id}/{filename}', [App\Http\Controllers\FileController::class, 'download'])->name('download');
});
