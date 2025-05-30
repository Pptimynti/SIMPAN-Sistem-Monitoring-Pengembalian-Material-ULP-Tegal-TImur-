<?php

namespace Database\Seeders;

use App\Models\Pekerjaan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PekerjaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pekerjaan::create([
            'no_agenda' => 'Kereng',
            'no_pk' => 'afafasfafd',
            'tanggal_pk' => now(),
            'petugas' => 'Mahar',
            'nama_pelanggan' => 'Jooko',
            'mutasi' => 'Pemasangan baru',
        ]);
    }
}
