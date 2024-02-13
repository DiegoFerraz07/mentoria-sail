<?php

namespace App\Interfaces;

use App\Http\Requests\Product\ProductAddFormRequest;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    public function getAll(): Collection;
    public function get(int $id): Product|null;
    public function find(string $search): Collection;
    public function delete(int $id): bool;
    public function store(ProductAddFormRequest $request): array;
}    
   
