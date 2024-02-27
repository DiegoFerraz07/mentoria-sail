<?php

namespace App\Models;

use App\Http\Requests\ProductTypes\ProductTypesAddFormRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTypes extends Model
{
    use HasFactory;
    protected $table = 'produtos_types';
    protected $fillable =  [
        'type_id',
        'product_id',
    ];

    public function fillProductTypes(ProductTypesAddFormRequest $request): ProductTypes
    {
        $this->type_id = $request->type_id;
        $this->product_id = $request->product_id;
        return $this;
    }
}
