<?php

namespace App\Interfaces;

use App\Http\Requests\Supply\SupplyAddFormRequest;
use App\Http\Requests\Supply\SupplyUpdateFormRequest;
use App\Models\Supply;
use Illuminate\Database\Eloquent\Collection;

interface SupplyRepositoryInterface
{
    public function getAll(): Collection;
    public function get(int $id): Supply|null;
    public function find(string $search): Collection;
    public function delete(int $id): bool;
    public function store(SupplyAddFormRequest $request): bool;
    public function update(SupplyUpdateFormRequest $request): bool;
}