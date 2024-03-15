<?php

namespace App\Interfaces;

use App\Http\Requests\ProductTypes\ProductTypesAddFormRequest;
use App\Models\ProductTypes;
use Exception;

interface ProductTypesRepositoryInterface
{
    public function store(int $productId, array $typesId): array;

}    