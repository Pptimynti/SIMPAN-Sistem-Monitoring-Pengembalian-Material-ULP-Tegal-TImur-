<?php

namespace App\Services\Implementations;

use App\Models\ActivityLog;
use App\Models\Material;
use App\Services\MaterialInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Log;
use Validator;

class MaterialService implements MaterialInterface
{

    public function update(int $materialId, array $data): bool
    {
        $validator = Validator::make($data, [
            'nama' => 'required|max:255',
            'satuan' => 'required|max:20'
        ]);

        if ($validator->fails()) {
            Log::warning('Request data failed: ' . $validator->errors());
        }

        $validatedData = $validator->validate();

        try {
            $materialBefore = Material::findOrFail($materialId);
            $material = Material::findOrFail($materialId);
            $material->update([
                'nama' => $validatedData['nama'],
                'satuan' => $validatedData['satuan']
            ]);

            $changes = [];
            if ($materialBefore->nama !== $material->nama) {
                $changes[] = "nama dari '{$materialBefore->nama}' menjadi '{$material->nama}'";
            }
            if ($materialBefore->satuan !== $material->satuan) {
                $changes[] = "satuan dari '{$materialBefore->satuan}' menjadi '{$material->satuan}'";
            }

            $deskripsi = "melakukan update data material";
            if (!empty($changes)) {
                $deskripsi .= ": " . implode(', ', $changes);
            }


            $user = Auth::user();

            ActivityLog::create([
                'user_id' => $user->id,
                'aktivitas' => 'Update Data Material',
                'deskripsi' => $deskripsi,
            ]);
            return true;
        } catch (Exception $e) {
            Log::warning('Gagal mengupdate material: ' . $e->getMessage());
            return false;
        }
    }

    public function store(array $data): bool
    {
        $validator = Validator::make($data, [
            'nama' => 'required|max:255',
            'satuan' => 'required|max:20'
        ]);

        if ($validator->fails()) {
            Log::warning('Request data failed: ' . $validator->errors());
        }

        $validatedData = $validator->validate();

        try {
            $material = Material::create([
                'nama' => $validatedData['nama'],
                'satuan' => $validatedData['satuan']
            ]);

            $user = Auth::user();

            ActivityLog::create([
                'user_id' => $user->id,
                'aktivitas' => 'Tambah Material Baru',
                'deskripsi' => "melakukan penambahan data material: $material->nama",
            ]);
            return true;
        } catch (Exception $e) {
            Log::warning('Gagal menambahkan material: ' . $e->getMessage());
            return false;
        }
    }

    public function destroy(int $materialId): bool
    {
        $material = Material::findOrFail($materialId);
        $user = Auth::user();

        ActivityLog::create([
            'user_id' => $user->id,
            'aktivitas' => 'Menghapus Material Baru',
            'deskripsi' => "melakukan penghapusan data material: $material->nama",
        ]);

        return Material::findOrFail($materialId)->delete();
    }
}
