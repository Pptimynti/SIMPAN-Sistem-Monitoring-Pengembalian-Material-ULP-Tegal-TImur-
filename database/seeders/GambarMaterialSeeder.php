<?php

namespace Database\Seeders;

use App\Models\GambarMaterial;
use App\Models\MaterialDikembalikan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;

class GambarMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materialDiekembalikan = MaterialDikembalikan::first();
        GambarMaterial::create([
            'material_dikembalikan_id' => $materialDiekembalikan->id,
            'gambar' => UploadedFile::fake()->image('keren.jpg'),
        ]);
    }
}
