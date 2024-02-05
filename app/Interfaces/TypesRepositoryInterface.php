<?php

namespace App\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TypesRepositoryInterface
{
    public function getAll(): LengthAwarePaginator;

}
