<?php

namespace App\Services;

interface MaterialBekasInterface
{
    public function menggunakanMaterialBekas(int $materialBekasId, int $jumlah): bool;
    public function menyesuaikanStokManual(int $materialId, int $jumlah): bool;
}
