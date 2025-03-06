<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\MaterialBekas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialBekasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $material = Material::first();
        MaterialBekas::create([
            'material_id' => $material->id,
            'stok_tersedia' => 10,
            'telah_digunakan' => 0,
            'stok_manual' => 30
        ]);
    }
}
