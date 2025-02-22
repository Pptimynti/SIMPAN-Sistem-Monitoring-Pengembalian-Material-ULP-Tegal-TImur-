<?php

namespace App\Services;

interface MaterialInterface
{
    public function store(array $data): bool;
    public function destroy(int $materialId): bool;
    public function update(int $materialId, array $data): bool;
}
