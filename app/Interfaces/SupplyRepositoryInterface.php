<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface SupplyRepositoryInterface
{
    public function getAll(): Collection;
    public function find(string $search): Collection;
}