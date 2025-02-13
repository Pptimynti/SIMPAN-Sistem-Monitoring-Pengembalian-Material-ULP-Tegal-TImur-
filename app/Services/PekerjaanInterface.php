<?php

namespace App\Services;

interface PekerjaanInterface
{
    public function tambahPekerjaan(array $data): bool;
    public function hapusPekerjaan(int $idPekerjaan): bool;
    public function updatePekerjaan(int $idPekerjaan, array $data): bool;
}
