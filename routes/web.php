<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BisnisController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TransaksiController;

Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

Route::middleware('only_guest')->group(function(){
    Route::get('login',[AuthController::class, 'login'])->name('login');
    Route::post('login',[AuthController::class, 'authenticating']);
    Route::get('register',[AuthController::class, 'register']);
    Route::post('register',[AuthController::class, 'registerUser']);
});

Route::middleware('auth')->group(function(){
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('dashboard_owner', [DashboardController::class, 'dash_owner'])->middleware('only_owner');
    Route::get('dashboard_emp', [DashboardController::class, 'dash_emp'])->middleware('only_emp');
    Route::get('profile', [ProfileController::class, 'profile']);
    Route::get('bisnis_anda', [BisnisController::class, 'bisnis']);

    Route::get('pemasok', [PemasokController::class, 'pemasok']);
    Route::get('add-pemasok', [PemasokController::class, 'add']);
    Route::post('add-pemasok', [PemasokController::class, 'store']);
    Route::get('edit-pemasok/{id}', [PemasokController::class, 'edit'])->name('edit-pemasok');
    Route::put('update-pemasok/{id}', [PemasokController::class, 'update'])->name('update-pemasok');
    Route::delete('delete-pemasok/{id}', [PemasokController::class, 'destroy'])->name('delete-pemasok');

    Route::get('pelanggan', [PelangganController::class, 'pelanggan']);
    Route::get('add-pelanggan', [PelangganController::class, 'add']);
    Route::post('add-pelanggan', [PelangganController::class, 'store']);
    Route::get('edit-pelanggan/{id}', [PelangganController::class, 'edit'])->name('edit-pelanggan');
    Route::put('update-pelanggan/{id}', [PelangganController::class, 'update'])->name('update-pelanggan');
    Route::delete('delete-pelanggan/{id}', [PelangganController::class, 'destroy'])->name('delete-pelanggan');
    Route::delete('delete-pelanggan/{id}', [PelangganController::class, 'destroy'])->name('delete-pelanggan');

    Route::get('lap_keuangan', [LaporanController::class, 'laporan']);
    Route::get('transaksi', [TransaksiController::class, 'transaksi']);
    Route::get('pelanggan', [PelangganController::class, 'pelanggan']);
});

// Route::get('/register', [RoleController::class, 'index']);
// Route::get('/user/{id_role}', [RoleController::class, 'getRole']);



