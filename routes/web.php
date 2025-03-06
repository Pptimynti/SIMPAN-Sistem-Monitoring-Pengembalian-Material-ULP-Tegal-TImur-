<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\GuestMiddleware;
use App\Http\Middleware\ManagerMiddleware;
use App\Http\Middleware\PetugasMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('login'));
})->middleware(GuestMiddleware::class);

require __DIR__ . '/auth.php';

Route::controller(AdminController::class)->middleware(AdminMiddleware::class)->prefix('/admin')->group(function () {
    Route::get('/dashboard', 'dashboard')->name('admin.dashboard');
    Route::get('/pengembalian-material', 'pengembalianMaterial')->name('admin.pengembalian-material');
    Route::get('/pengembalian-material/tambah', 'halamanTambahPengembalianMaterial')->name('admin.halaman-tambah-pengembalian-material');
    Route::post('/pengembalian-material/tambah', 'tambahPengembalianMaterial')->name('admin.tambah-pengembalian-material');
    Route::get('/pengembalian-material/{pekerjaanId}/edit', 'editPengembalianMaterial')->name('admin.edit.pengembalian-material');
    Route::put('/pengembalian-material/{pekerjaanId}/update', 'updatePengembalianMaterial')->name('admin.update.pengembalian-material');
    Route::delete('/pengembalian-material/{pekerjaanId}/hapus', 'hapusPengembalianMaterial')->name('admin.hapus.pengembalian-material');

    Route::get('/rekap-data/pengembalian-material', 'rekapPengembalianMaterial')->name('admin.laporan.pengembalian-material');
    Route::get('/rekap-data/pengembalian-material/{pekerjaanId}/detail', 'rekapDetailPengembalianMaterial')->name('admin.laporan.detail.pengembalian-material');

    Route::get('/pengembalian-material/{pekerjaanId}/export', 'exportDetailPengembalianMaterial')->name('export.detail-pengembalian-material');
    Route::get('/pengembalian-material/{pekerjaanId}/exportPdf', 'cetakPdfDetailPengembalianMaterial')->name('exportPdf.detail-pengembalian-material');

    Route::get('/profile', 'profileEdit')->name('admin.profile-edit');
    Route::patch('/profile', 'profileUpdate')->name('admin.profile-update');
    Route::delete('/profile', 'profileDestroy')->name('admin.profile-destroy');

    Route::get('/users', 'users')->name('admin.users');
    Route::post('/users/tambah-user', 'tambahUser')->name('admin.tambah-user');
    Route::put('/users/update', 'updateUser')->name('admin.update-user');
    Route::delete('/users/{userId}/hapus', 'hapusUser')->name('admin.hapus-user');

    Route::get('/material-return', 'stokMaterialReturn')->name('admin.material-return');
    Route::put('/material-return/update', 'menggunakanMaterialBekas')->name('admin.menggunakan-material-return');
    Route::put('/material-return/stok-manual', 'menyesuaikanStokManual')->name('admin.menyesuaikan-stok-manual');

    Route::get('/daftar-material', 'daftarMaterial')->name('admin.daftar-material');
    Route::post('/daftar-material/tambah', 'tambahMaterial')->name('admin.tambah-material');
    Route::put('/daftar-material/update', 'updateMaterial')->name('admin.update-material');
    Route::delete('/daftar-material/{idMaterial}/delete', 'deleteMaterial')->name('admin.delete-material');
    Route::get('/daftar-material/{materialId}/show', 'showMaterial')->name('admin.material.show');
});

Route::controller(PetugasController::class)->middleware(PetugasMiddleware::class)->prefix('/petugas')->group(function () {
    Route::get('/dashboard', 'dashboard')->name('petugas.dashboard');
    Route::get('/pengembalian-material', 'pengembalianMaterial')->name('petugas.pengembalian-material');
    Route::get('/pengembalian-material/tambah', 'halamanTambahPengembalianMaterial')->name('petugas.halaman.tambah.pengembalian-material');
    Route::post('/pengembalian-material/tambah', 'tambahPengembalianMaterial')->name('petugas.tambah.pengembalian-material');
});

Route::controller(ManagerController::class)->middleware(ManagerMiddleware::class)->prefix('/manager')->group(function () {
    Route::get('/dashboard', 'dashboard')->name('manager.dashboard');
    Route::get('/stok-material-return', 'stokMaterialReturn')->name('manager.stok-material-return');
    Route::get('/rekap-pengembalian-material', 'rekapDataPengembalianMaterial')->name('manager.rekap-pengembalian');
});

Route::prefix('/admin/api')->controller(AdminController::class)->group(function () {
    Route::get('/material-bekas/{materialId}', 'materialBekasById')->name('admin.materialBekasById');
    Route::get('/users/{userId}/show', 'showUser')->name('show.user');
});

