<?php

namespace App\Services\Implementations;

use App\Models\ActivityLog;
use App\Models\MaterialBekas;
use App\Models\MaterialDikembalikan;
use App\Services\MaterialBekasInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MaterialBekasService implements MaterialBekasInterface
{
    public function menggunakanMaterialBekas(int $materialBekasId, int $jumlah): bool
    {
        try {
            $materialBekas = MaterialBekas::findOrFail($materialBekasId);

            $stok_digunakan = $materialBekas->telah_digunakan + $jumlah;

            $total_jumlah_dikembalikan = MaterialDikembalikan::where('material_id', $materialBekas->material_id)
                ->sum('jumlah');

            $stok_tersedia = $total_jumlah_dikembalikan - $stok_digunakan + $materialBekas->stok_manual;

            $user = Auth::user();

            ActivityLog::create([
                'user_id' => $user->id,
                'aktivitas' => 'Menggunakan Material Return',
                'deskripsi' => "menggunakan material bekas {$materialBekas->material->nama} dengan jumlah {$jumlah}",
                'material_bekas_id' => $materialBekas->id,
                'jumlah' => $jumlah
            ]);

            return $materialBekas->update([
                'telah_digunakan' => $stok_digunakan,
                'stok_tersedia' => $stok_tersedia,
            ]);

        } catch (Exception $e) {
            \Log::error('Gagal menggunakan material:', ['error' => $e->getMessage()]);
            return false;
        }
    }

    public function menyesuaikanStokManual(int $materialId, int $jumlah): bool
    {
        try {
            $stok_manual = $jumlah;

            $materialBekas = MaterialBekas::updateOrCreate(
                ['material_id' => $materialId],
                [
                    'stok_manual' => $stok_manual,
                    'telah_digunakan' => $materialBekas->telah_digunakan ?? 0,
                    'stok_tersedia' => $materialBekas->stok_tersedia ?? 0
                ]
            );

            $total_jumlah_dikembalikan = MaterialDikembalikan::where('material_id', $materialBekas->material_id)->sum('jumlah');
            $stok_tersedia = $total_jumlah_dikembalikan - $materialBekas->telah_digunakan + $materialBekas->stok_manual;

            $user = Auth::user();

            ActivityLog::create([
                'user_id' => $user->id,
                'aktivitas' => 'Menggunakan Material Return',
                'deskripsi' => "menyesuaikan stok material bekas {$materialBekas->material->nama}",
                'material' => $materialBekas->material->nama,
                'jumlah' => $jumlah
            ]);

            $updateResult = $materialBekas->update([
                'stok_tersedia' => $stok_tersedia
            ]);

            return $updateResult;
        } catch (Exception $e) {
            \Log::error('Gagal menggunakan material:', ['error' => $e->getMessage()]);
            return false;
        }
    }


}
