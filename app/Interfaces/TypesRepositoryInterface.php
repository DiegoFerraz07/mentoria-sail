<?php

namespace App\Interfaces;

use App\Models\Types;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface TypesRepositoryInterface
{
    public function getAll(): LengthAwarePaginator;
    public function all(): Collection;

}
