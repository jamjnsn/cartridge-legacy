<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
	Route::get('/files/{id}/{filename}', [App\Http\Controllers\FileController::class, 'download'])->name('download');
});

Route::prefix('admin')->group(function () {
	Route::view('/', 'admin.dashboard');
	Route::get('/users', [UsersController::class, 'index'])->name('admin.users');

	Route::get('/users/new', [UsersController::class, 'new'])->name('admin.users.new');
	Route::post('/users/new', [UsersController::class, 'create']);

	Route::get('/users/{user}', [UsersController::class, 'edit'])->name('admin.users.edit')->missing(function (Request $request) {
		$request->session()->flash('status', ['type' => 'error', 'message' => 'User not found.']);
		return Redirect::route('admin.users');
	});

	Route::post('/users/{user}', [UsersController::class, 'update'])->missing(function (Request $request) {
		$request->session()->flash('status', ['type' => 'error', 'message' => 'User not found.']);
		return Redirect::route('admin.users');
	});

	Route::delete('/users/{user}', [UsersController::class, 'delete'])->missing(function (Request $request) {
		$request->session()->flash('status', ['type' => 'error', 'message' => 'User not found.']);
		return Redirect::route('admin.users');
	});
});
