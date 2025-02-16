<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


Route::controller(AdminController::class)->prefix('/admin')->group(function () {
    Route::get('/dashboard', 'dashboard')->name('admin.dashboard');
    Route::get('/pengembalian-material', 'pengembalianMaterial')->name('admin.pengembalian-material');
    Route::get('/pengembalian-material/{pekerjaanId}/edit', 'editPengembalianMaterial')->name('admin.edit.pengembalian-material');
    Route::put('/pengembalian-material/{pekerjaanId}/update', 'updatePengembalianMaterial')->name('admin.update.pengembalian-material');
    Route::delete('/pengembalian-material/{pekerjaanId}/hapus', 'hapusPengembalianMaterial')->name('admin.hapus.pengembalian-material');
    Route::get('/rekap-data/pengembalian-material', 'rekapPengembalianMaterial')->name('admin.laporan.pengembalian-material');
    Route::get('/rekap-data/pengembalian-material/{pekerjaanId}/detail', 'rekapDetailPengembalianMaterial')->name('admin.laporan.detail.pengembalian-material');
    Route::get('/pengembalian-material/{pekerjaanId}/export', 'exportDetailPengembalianMaterial')->name('export.detail-pengembalian-material');
    Route::get('/pengembalian-material/{pekerjaanId}/exportPdf', 'cetakPdfDetailPengembalianMaterial')->name('exportPdf.detail-pengembalian-material');
});

Route::controller(PetugasController::class)->prefix('/petugas')->group(function () {
    Route::get('/dashboard', 'dashboard')->name('petugas.dashboard');
    Route::get('/pengembalian-material', 'pengembalianMaterial')->name('petugas.pengembalian-material');
    Route::get('/pengembalian-material/tambah', 'halamanTambahPengembalianMaterial')->name('petugas.halaman.tambah.pengembalian-material');
    Route::post('/pengembalian-material/tambah', 'tambahPengembalianMaterial')->name('petugas.tambah.pengembalian-material');
});


Route::get('/storage-link', function () {
    File::copyDirectory(storage_path('app/public'), public_path('storage'));
    return 'Storage copied!';
});
