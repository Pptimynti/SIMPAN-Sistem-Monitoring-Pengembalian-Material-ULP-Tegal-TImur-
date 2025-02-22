<?php

namespace App\Services;

interface UserInterface
{
    public function store(array $data): bool;
    public function destroy(int $userId): bool;
    public function update(int $userId, array $data): bool;
}
