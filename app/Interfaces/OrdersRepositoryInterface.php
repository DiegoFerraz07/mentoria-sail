<?php

namespace App\Interfaces;

use App\Http\Requests\Client\OrdersAddFormRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface OrdersRepositoryInterface
{
    public function getAll(): LengthAwarePaginator;
    public function store(OrdersAddFormRequest $request): array;
}
