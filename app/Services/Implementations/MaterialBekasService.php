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
            $materialBekas = MaterialBekas::firstOrNew(['material_id' => $materialId]);

            $materialBekas->stok_manual = $jumlah;
            $materialBekas->telah_digunakan = $materialBekas->telah_digunakan ?? 0;
            $materialBekas->stok_tersedia = $materialBekas->stok_tersedia ?? 0;

            $materialBekas->save();

            $total_jumlah_dikembalikan = MaterialDikembalikan::where('material_id', $materialBekas->material_id)->sum('jumlah');

            $stok_tersedia = $total_jumlah_dikembalikan - $materialBekas->telah_digunakan + $materialBekas->stok_manual;

            $materialBekas->stok_tersedia = $stok_tersedia;
            $updateResult = $materialBekas->save();

            $user = Auth::user();
            ActivityLog::create([
                'user_id' => $user->id,
                'aktivitas' => 'Menyesuaikan Material Return',
                'deskripsi' => "menyesuaikan stok material bekas {$materialBekas->material->nama} dengan jumlah {$jumlah}",
            ]);

            return $updateResult;
        } catch (Exception $e) {
            \Log::error('Gagal menyesuaikan stok manual:', ['error' => $e->getMessage()]);
            return false;
        }
    }


}
