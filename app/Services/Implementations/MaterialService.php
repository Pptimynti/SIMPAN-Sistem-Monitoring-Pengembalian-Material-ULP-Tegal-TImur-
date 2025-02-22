<?php

namespace App\Services\Implementations;

use App\Models\Material;
use App\Services\MaterialInterface;
use Exception;
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
            $material = Material::findOrFail($materialId);
            $material->update([
                'nama' => $validatedData['nama'],
                'satuan' => $validatedData['satuan']
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
            Material::create([
                'nama' => $validatedData['nama'],
                'satuan' => $validatedData['satuan']
            ]);
            return true;
        } catch (Exception $e) {
            Log::warning('Gagal menambahkan material: ' . $e->getMessage());
            return false;
        }
    }

    public function destroy(int $materialId): bool
    {
        return Material::findOrFail($materialId)->delete();
    }
}
