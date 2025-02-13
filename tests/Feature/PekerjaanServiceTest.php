<?php

namespace Tests\Feature;

use App\Models\GambarMaterial;
use App\Models\MaterialDikembalikan;
use App\Models\Pekerjaan;
use App\Services\PekerjaanInterface;
use Database\Seeders\GambarMaterialSeeder;
use Database\Seeders\MaterialDikembalikanSeeder;
use Database\Seeders\PekerjaanSeeder;
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
        $data = [
            'no_agenda' => 'Kereng',
            'petugas' => 'Mahar',
            'nama_pelanggan' => 'Jooko',
            'mutasi' => 'Pemasangan baru',
            'material_dikembalikan' => [
                [
                    'nama' => 'KWH',
                    'jumlah' => 20,
                    'gambar' => [
                        UploadedFile::fake()->image('image.jpg')
                    ]
                ],
                [
                    'nama' => 'MCB',
                    'jumlah' => 20,
                    'gambar' => [
                        UploadedFile::fake()->image('image.jpg')
                    ]
                ]
            ],
        ];

        self::assertTrue($this->pekerjaanService->tambahPekerjaan($data));
    }

    public function testUpdatePekerjaan()
    {
        $this->seed([PekerjaanSeeder::class, MaterialDikembalikanSeeder::class, GambarMaterialSeeder::class]);
        $pekerjaan = Pekerjaan::first();
        self::assertEquals('Mahar', $pekerjaan->petugas);
        $materialDikembalikan = MaterialDikembalikan::first();
        self::assertEquals('KWH', $materialDikembalikan->nama);
        $gambarMaterial = GambarMaterial::first();
        self::assertEquals($materialDikembalikan->id, $gambarMaterial->material_dikembalikan_id);

        $data = [
            'no_agenda' => 'Kereng',
            'petugas' => 'Dhika',
            'nama_pelanggan' => 'Jooko',
            'mutasi' => 'Pemasangan baru',
            'material_dikembalikan' => [
                [
                    'id' => $materialDikembalikan->id,
                    'nama' => 'Kabel',
                    'jumlah' => 100,
                    'gambar' => [
                        UploadedFile::fake()->image('newImage.jpg'),
                    ]
                ],
                [
                    'nama' => 'KWH',
                    'jumlah' => 10,
                    'gambar' => [
                        UploadedFile::fake()->image('newImage.jpg')
                    ],
                ]
            ]
        ];

        self::assertTrue($this->pekerjaanService->updatePekerjaan($pekerjaan->id, $data));
        self::assertEquals('Dhika', Pekerjaan::first()->petugas);
        self::assertEquals('Kabel', MaterialDikembalikan::first()->nama);

        $materialDikembalikans = MaterialDikembalikan::all();
        foreach ($materialDikembalikans as $material) {
            Log::debug('Voba gays', ['material' => $material]);
        }
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
