<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\MaterialDikembalikan;
use App\Models\Pekerjaan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialDikembalikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pekerjaan = Pekerjaan::first();
        $material = Material::first();

        MaterialDikembalikan::create([
            'pekerjaan_id' => $pekerjaan->id,
            'material_id' => $material->id,
            'jumlah' => 12
        ]);
    }
}
