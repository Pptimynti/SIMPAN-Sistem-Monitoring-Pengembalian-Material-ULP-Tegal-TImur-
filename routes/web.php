<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\PetugasMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

require __DIR__ . '/auth.php';

Route::controller(AdminController::class)->prefix('/admin')->middleware(AdminMiddleware::class)->group(function () {
    Route::get('/dashboard', 'dashboard')->name('admin.dashboard');
    Route::get('/pengembalian-material', 'pengembalianMaterial')->name('admin.pengembalian-material');
    Route::get('/pengembalian-material/{pekerjaanId}/edit', 'editPengembalianMaterial')->name('admin.edit.pengembalian-material');
    Route::put('/pengembalian-material/{pekerjaanId}/update', 'updatePengembalianMaterial')->name('admin.update.pengembalian-material');
    Route::delete('/pengembalian-material/{pekerjaanId}/hapus', 'hapusPengembalianMaterial')->name('admin.hapus.pengembalian-material');
    Route::get('/rekap-data/pengembalian-material', 'rekapPengembalianMaterial')->name('admin.laporan.pengembalian-material');
    Route::get('/rekap-data/pengembalian-material/{pekerjaanId}/detail', 'rekapDetailPengembalianMaterial')->name('admin.laporan.detail.pengembalian-material');
    Route::get('/pengembalian-material/{pekerjaanId}/export', 'exportDetailPengembalianMaterial')->name('export.detail-pengembalian-material');
    Route::get('/pengembalian-material/{pekerjaanId}/exportPdf', 'cetakPdfDetailPengembalianMaterial')->name('exportPdf.detail-pengembalian-material');
    Route::get('/profile', 'profileEdit')->name('profile.edit');
    Route::patch('/profile', 'profileUpdate')->name('profile.update');
    Route::delete('/profile', 'profileDestroy')->name('profile.destroy');
});

Route::controller(PetugasController::class)->prefix('/petugas')->middleware(PetugasMiddleware::class)->group(function () {
    Route::get('/dashboard', 'dashboard')->name('petugas.dashboard');
    Route::get('/pengembalian-material', 'pengembalianMaterial')->name('petugas.pengembalian-material');
    Route::get('/pengembalian-material/tambah', 'halamanTambahPengembalianMaterial')->name('petugas.halaman.tambah.pengembalian-material');
    Route::post('/pengembalian-material/tambah', 'tambahPengembalianMaterial')->name('petugas.tambah.pengembalian-material');
});
