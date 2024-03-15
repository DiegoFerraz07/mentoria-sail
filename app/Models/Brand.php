<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'brand';

    public function fillBrand($request) : Brand
    {
        $this->name = $request->name;
        $this->description = $request->description;
        return $this;
    }
}
