<?php

namespace Tests\Feature;

use App\Models\Material;
use App\Services\MaterialInterface;
use Database\Seeders\MaterialSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MaterialServiceTest extends TestCase
{
    use RefreshDatabase;
    private MaterialInterface $materialService;

    public function setUp(): void
    {
        parent::setUp();
        $this->materialService = app(MaterialInterface::class);
    }

    public function test()
    {
        self::assertTrue(true);
    }

    public function testStoreMaterial()
    {
        self::assertCount(0, Material::all());
        self::assertTrue($this->materialService->store([
            'nama' => 'KWH',
            'satuan' => 'Unit'
        ]));
        self::assertCount(1, Material::all());
    }

    public function testUpdateMaterial()
    {
        $this->seed(MaterialSeeder::class);
        $material = Material::first();
        self::assertEquals('KWH', $material->nama);

        self::assertTrue($this->materialService->update($material->id, [
            'nama' => 'MCB',
            'satuan' => 'Unit'
        ]));

        self::assertEquals('MCB', Material::first()->nama);
    }

    public function testDestroyMaterial()
    {
        $this->seed(MaterialSeeder::class);
        $material = Material::first();
        self::assertCount(1, Material::all());

        self::assertTrue($this->materialService->destroy($material->id));

        self::assertCount(0, Material::all());
    }
}
