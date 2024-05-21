<?php

namespace App\Interfaces;

use App\Http\Requests\Orders\OrdersAddFormRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface OrdersRepositoryInterface
{
    public function getAll(): LengthAwarePaginator|Collection;
    public function store(OrdersAddFormRequest $request): array;
}
