<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BisnisController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
})->middleware('auth');
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'authenticating'])->name('login');
Route::middleware('only_guest')->group(function(){

    Route::get('register', [AuthController::class, 'register']);
    Route::post('register', [AuthController::class, 'registerUser']);
});

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->middleware('auth')->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect('login');
    })->middleware(['auth', 'signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
});


Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('dashboard_owner', [DashboardController::class, 'dash_owner'])->middleware('only_owner')->name('dashboard_owner');
    Route::get('dashboard_emp', [DashboardController::class, 'dash_emp'])->middleware('only_emp')->name('dashboard_emp');

    Route::get('profile', [ProfileController::class, 'profile'])->name('profile')->middleware('verified');;
    Route::get('edit-profile', [ProfileController::class, 'editProfile'])->name('profile.edit');
    Route::put('profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');

    Route::get('bisnis_anda', [BisnisController::class, 'bisnis'])->name('bisnis_anda');
    Route::get('edit-bisnis_anda/{id}', [BisnisController::class, 'editBisnis'])->name('bisnis.edit');
    Route::put('bisnis/{id}/update', [BisnisController::class, 'updateBisnis'])->name('bisnis.update');

    Route::get('barang/{id}', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/barang/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
    Route::post('/barang/update', [BarangController::class, 'update'])->name('barang.update');
    Route::get('/umkm/{id}/barang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/barang/store', [BarangController::class, 'store'])->name('barang.store');
    Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');

    Route::get('pemasok', [PemasokController::class, 'pemasok'])->name('pemasok');
    Route::get('add-pemasok', [PemasokController::class, 'add']);
    Route::post('add-pemasok', [PemasokController::class, 'store']);
    Route::get('edit-pemasok/{id}', [PemasokController::class, 'edit'])->name('edit-pemasok');
    Route::put('update-pemasok/{id}', [PemasokController::class, 'update'])->name('update-pemasok');
    Route::delete('delete-pemasok/{id}', [PemasokController::class, 'destroy'])->name('delete-pemasok');

    Route::get('pelanggan', [PelangganController::class, 'pelanggan'])->name('pelanggan');
    Route::get('add-pelanggan', [PelangganController::class, 'add']);
    Route::post('add-pelanggan', [PelangganController::class, 'store']);
    Route::get('edit-pelanggan/{id}', [PelangganController::class, 'edit'])->name('edit-pelanggan');
    Route::put('update-pelanggan/{id}', [PelangganController::class, 'update'])->name('update-pelanggan');
    Route::delete('delete-pelanggan/{id}', [PelangganController::class, 'destroy'])->name('delete-pelanggan');
    Route::delete('delete-pelanggan/{id}', [PelangganController::class, 'destroy'])->name('delete-pelanggan');

    Route::get('lap_keuangan', [LaporanController::class, 'laporan'])->name('lap_keuangan');
    Route::get('/laporan/{bulan}', [LaporanController::class, 'detailLaporan']);

    Route::get('transaksi', [TransaksiController::class, 'transaksi'])->name('transaksi');
    Route::get('transaksi-detail/{id}', [TransaksiController::class, 'detail'])->name('transaksi-detail');
    Route::delete('transaksi/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
    Route::get('add-transaksi', [TransaksiController::class, 'addTransaksi'])->name('transaksi.addTransaksi');
    Route::post('add-transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('transaksi/{id}/add-detail', [TransaksiController::class, 'addDetail'])->name('transaksi.addDetail');
    Route::post('transaksi/{id}/add-detail', [TransaksiController::class, 'storeDetail'])->name('transaksi.storeDetail');
    Route::delete('transaksi/detail/{id}', [TransaksiController::class, 'destroyDetail'])->name('transaksi.destroyDetail');
    Route::get('transaksi/{id}/edit', [TransaksiController::class, 'edit'])->name('transaksi.edit');
    Route::put('transaksi/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');
    Route::get('transaksi/detail/{id}/edit', [TransaksiController::class, 'editDetail'])->name('transaksi.editDetail');
    Route::put('transaksi/detail/{id}', [TransaksiController::class, 'updateDetail'])->name('transaksi.updateDetail');

    Route::get('umkm-list', [BisnisController::class, 'umkm'])->name('umkm-list');
    Route::get('add-umkm', [BisnisController::class, 'add']);
    Route::post('add-umkm', [BisnisController::class, 'store']);
    Route::post('join-umkm/{id}', [BisnisController::class, 'joinUmkm'])->name('join-umkm');

    Route::put('update-employee-status/{id}', [BisnisController::class, 'updateEmployeeStatus'])->name('update-employee-status');
});

