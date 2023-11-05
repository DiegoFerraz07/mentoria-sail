<?php

namespace App\Interfaces;

use App\Http\Requests\Client\ClientAddFormRequest;
use App\Http\Requests\Client\ClientUpdateFormRequest;
use App\Models\Client;
use Illuminate\Database\Eloquent\Collection;

interface ClientRepositoryInterface
{
    public function getAll(): Collection;
    public function get(int $id): Client|null;
    public function find(string $search): Collection;
    public function delete(int $id): bool;
    public function store(ClientAddFormRequest $request): array;
    public function update(ClientUpdateFormRequest $request): bool;

}
