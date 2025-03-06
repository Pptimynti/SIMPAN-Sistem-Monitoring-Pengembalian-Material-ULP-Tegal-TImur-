<?php

namespace App\Services\Implementations;

use App\Models\MaterialBekas;
use App\Models\MaterialDikembalikan;
use App\Services\MaterialBekasInterface;
use Exception;
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
            \Log::info('Mulai menyesuaikan stok manual', ['material_id' => $materialId, 'jumlah' => $jumlah]);

            $stok_manual = $jumlah;

            $materialBekas = MaterialBekas::updateOrCreate(
                ['material_id' => $materialId],
                [
                    'stok_manual' => $stok_manual,
                    'telah_digunakan' => $materialBekas->telah_digunakan ?? 0,
                    'stok_tersedia' => $materialBekas->stok_tersedia ?? 0
                ]
            );

            \Log::info('Material bekas ditemukan atau diperbarui', $materialBekas->toArray());

            $total_jumlah_dikembalikan = MaterialDikembalikan::where('material_id', $materialBekas->material_id)->sum('jumlah');

            \Log::info('Total jumlah dikembalikan', ['total_jumlah_dikembalikan' => $total_jumlah_dikembalikan]);

            $stok_tersedia = $total_jumlah_dikembalikan - $materialBekas->telah_digunakan + $materialBekas->stok_manual;

            \Log::info('Stok tersedia dihitung', [
                'stok_manual' => $materialBekas->stok_manual,
                'telah_digunakan' => $materialBekas->telah_digunakan,
                'stok_tersedia' => $stok_tersedia
            ]);

            $updateResult = $materialBekas->update([
                'stok_tersedia' => $stok_tersedia
            ]);

            \Log::info('Stok material bekas diupdate', ['update_result' => $updateResult]);

            return $updateResult;
        } catch (Exception $e) {
            \Log::error('Gagal menggunakan material:', ['error' => $e->getMessage()]);
            return false;
        }
    }


}
