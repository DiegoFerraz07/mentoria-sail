<?php

namespace App\Interfaces;

use App\Http\Requests\SupplyAddFormRequest;
use Illuminate\Database\Eloquent\Collection;

interface SupplyRepositoryInterface
{
    public function getAll(): Collection;
    public function find(string $search): Collection;
    public function delete(int $id): bool;
    public function store(SupplyAddFormRequest $request): void;
}