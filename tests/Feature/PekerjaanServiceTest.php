<?php

namespace Tests\Feature;

use App\Models\GambarMaterial;
use App\Models\Material;
use App\Models\MaterialBekas;
use App\Models\MaterialDikembalikan;
use App\Models\Pekerjaan;
use App\Services\PekerjaanInterface;
use Database\Seeders\GambarMaterialSeeder;
use Database\Seeders\MaterialDikembalikanSeeder;
use Database\Seeders\MaterialSeeder;
use Database\Seeders\PekerjaanSeeder;
use Date;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Log;
use Tests\TestCase;

class PekerjaanServiceTest extends TestCase
{
    use RefreshDatabase;

    private PekerjaanInterface $pekerjaanService;

    public function setUp(): void
    {
        parent::setUp();
        $this->pekerjaanService = app(PekerjaanInterface::class);
    }

    public function test()
    {
        self::assertTrue(true);
    }

    public function testStorePekerjaan()
    {
        $this->seed(MaterialSeeder::class);
        $material = Material::first();
        $data = [
            'no_agenda' => 'Kereng',
            'no_pk' => 'adfasdfasf',
            'tanggal_pk' => now(),
            'petugas' => 'Mahar',
            'nama_pelanggan' => 'Jooko',
            'mutasi' => 'Pemasangan baru',
            'material_dikembalikan' => [
                [
                    'material_id' => $material->id,
                    'jumlah' => 20,
                    'gambar' => [
                        UploadedFile::fake()->image('image.jpg')
                    ]
                ],
            ],
        ];

        self::assertTrue($this->pekerjaanService->tambahPekerjaan($data));
        self::assertCount(1, MaterialBekas::all());
    }

    public function testUpdatePekerjaan()
    {
        $this->seed([PekerjaanSeeder::class, MaterialSeeder::class, MaterialDikembalikanSeeder::class, GambarMaterialSeeder::class]);
        $pekerjaan = Pekerjaan::first();
        self::assertEquals('Mahar', $pekerjaan->petugas);
        $materialDikembalikan = MaterialDikembalikan::first();
        self::assertEquals('KWH', $materialDikembalikan->material->nama);
        $gambarMaterial = GambarMaterial::first();
        self::assertEquals($materialDikembalikan->id, $gambarMaterial->material_dikembalikan_id);
        $material = Material::first();
        self::assertEquals('KWH', $material->nama);

        $data = [
            'no_agenda' => 'Kereng',
            'petugas' => 'Dhika',
            'no_pk' => 'afafaadfadfaf',
            'tanggal_pk' => now(),
            'nama_pelanggan' => 'Jooko',
            'mutasi' => 'Pemasangan baru',
            'material_dikembalikan' => [
                [
                    'id' => $materialDikembalikan->id,
                    'material_id' => $material->id,
                    'jumlah' => 100,
                    'gambar' => [
                        UploadedFile::fake()->image('newImage.jpg'),
                    ]
                ],
            ]
        ];

        self::assertTrue($this->pekerjaanService->updatePekerjaan($pekerjaan->id, $data));
        self::assertEquals('Dhika', Pekerjaan::first()->petugas);

        $materialDikembalikans = MaterialDikembalikan::all();
        foreach ($materialDikembalikans as $material) {
            Log::debug('Voba gays', ['material' => $material]);
        }

        self::assertEquals(100, MaterialBekas::first()->stok);
    }

    public function testHapusPekerjaan()
    {
        $this->seed(PekerjaanSeeder::class);

        $pekerjaan = Pekerjaan::first();
        self::assertCount(1, Pekerjaan::all());

        self::assertTrue($this->pekerjaanService->hapusPekerjaan($pekerjaan->id));
        self::assertCount(0, Pekerjaan::all());
    }
}
