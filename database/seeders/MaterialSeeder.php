<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materials = [
            [
                'nama' => 'CABLE PWR NFA2X 2X10mm2 0.6/1kV OH (2x10)',
                'satuan' => 'meter',
            ],
            [
                'nama' => 'MTR kWH E-PR 1P 230V 5-60A 1 2W (Prabayar)',
                'satuan' => 'unit',
            ],
            [
                'nama' => 'MTR kWH E DRUM 1P 230V 5-40A 1 2W (Paskabayar)',
                'satuan' => 'unit',
            ],
            [
                'nama' => 'MCB 230/400V 1P 2A 50Hz',
                'satuan' => 'pcs',
            ],
            [
                'nama' => 'MCB 230/400V 1P 4A 50Hz',
                'satuan' => 'pcs',
            ],
            [
                'nama' => 'MCB 230/400V 1P 6A 50Hz',
                'satuan' => 'pcs',
            ],
            [
                'nama' => 'MCB 230/400V 1P 10A 50Hz',
                'satuan' => 'pcs',
            ],
            [
                'nama' => 'MCB 230/400V 1P 16A 50Hz',
                'satuan' => 'pcs',
            ],
            [
                'nama' => 'MCB 230/400V 1P 20A 50Hz',
                'satuan' => 'pcs',
            ],
            [
                'nama' => 'MCB 230/400V 1P 25A 50Hz',
                'satuan' => 'pcs',
            ],
            [
                'nama' => 'MCB 230/400V 1P 35A 50Hz',
                'satuan' => 'pcs',
            ],
            [
                'nama' => 'MCB 230/400V 1P 50A 50Hz',
                'satuan' => 'pcs',
            ],
        ];
        DB::table('materials')->insert($materials);
    }
}
