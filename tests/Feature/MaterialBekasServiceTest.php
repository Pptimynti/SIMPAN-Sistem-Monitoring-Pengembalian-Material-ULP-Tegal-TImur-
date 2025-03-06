<?php

namespace Tests\Feature;

use App\Models\MaterialBekas;
use App\Models\User;
use App\Services\MaterialBekasInterface;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\MaterialBekasSeeder;
use Database\Seeders\MaterialSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MaterialBekasServiceTest extends TestCase
{
    use RefreshDatabase;
    private MaterialBekasInterface $materialBekasService;

    public function setUp(): void
    {
        parent::setUp();
        $this->materialBekasService = app(MaterialBekasInterface::class);
    }

    public function test_menggunakan_material_bekas()
    {
        $this->seed([MaterialSeeder::class, MaterialBekasSeeder::class]);
        $materialBekas = MaterialBekas::first();

        self::assertTrue($this->materialBekasService->menggunakanMaterialBekas($materialBekas->id, 3));
        self::assertEquals(7, MaterialBekas::first()->stok_tersedia);
        self::assertEquals(3, MaterialBekas::first()->telah_digunakan);
    }

    public function test_controller_menggukanan_material_bekas()
    {
        $this->seed([DatabaseSeeder::class, MaterialSeeder::class, MaterialBekasSeeder::class]);
        $materialBekas = MaterialBekas::first();

        $this->actingAs(User::where('role', 'admin')->first());
        $this->put(route('admin.menggunakan-material-return', $materialBekas->id), [
            'jumlah' => 10
        ])->assertStatus(302)
            ->assertSessionHas('success');
    }

    public function test_controller_menggukanan_material_bekas_melebih_stok_tersedia()
    {
        $this->seed([DatabaseSeeder::class, MaterialSeeder::class, MaterialBekasSeeder::class]);
        $materialBekas = MaterialBekas::first();

        $this->actingAs(User::where('role', 'admin')->first());
        $this->put(route('admin.menggunakan-material-return', $materialBekas->id), [
            'jumlah' => 100
        ])->assertStatus(302)
            ->assertSessionHas('error');

        self::assertEquals(10, MaterialBekas::first()->stok_tersedia);
    }

}
