<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LogoutController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/kelola_user', [AdminController::class, 'kelola_user'])->name('kelola_user');
    Route::get('/kelola_user/add', [AdminController::class, 'create'])->name('user.create');
    Route::post('/kelola_user/store', [AdminController::class, 'store'])->name('user.store');
})->middleware(['auth', 'verified']);

Route::prefix('inventaris')->name('inventaris.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [InventarisController::class, 'index'])->name('list');
    Route::get('/show/{id}', [InventarisController::class, 'show'])->name('show');
    Route::get('/add', [InventarisController::class, 'create'])->name('create');
    Route::post('/store', [InventarisController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [InventarisController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [InventarisController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [InventarisController::class, 'destroy'])->name('delete');
    Route::get('/qr/{id}', [InventarisController::class, 'qrCreate'])->name('qr');
})->middleware(['auth', 'verified']);

Route::prefix('peminjaman')->name('peminjaman.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [PeminjamanController::class, 'index'])->name('index');
    Route::get('/show/{id}', [PeminjamanController::class, 'show'])->name('show');
    Route::get('/add', [PeminjamanController::class, 'create'])->name('add');
    Route::post('/store', [PeminjamanController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [PeminjamanController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [PeminjamanController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [PeminjamanController::class, 'destroy'])->name('delete');
    Route::get('/buktiPinjam/{id}', [PeminjamanController::class, 'buktiPinjam'])->name('buktiPinjam');
    Route::get('/buktiKembali/{id}', [PeminjamanController::class, 'buktiKembali'])->name('buktiKembali');
    Route::post('/scanReturn', [PeminjamanController::class, 'scanReturn'])->name('scanReturn');
});



Route::prefix('kategori')->name('kategori.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [KategoriController::class, 'index'])->name('index');
    Route::get('/add', [KategoriController::class, 'create'])->name('add');
    Route::post('/store', [KategoriController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [KategoriController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [KategoriController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [KategoriController::class, 'destroy'])->name('delete');
});

require __DIR__.'/auth.php';
