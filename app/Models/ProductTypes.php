<?php

namespace App\Models;

use App\Http\Requests\ProductTypes\ProductTypesAddFormRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTypes extends Model
{
    use HasFactory;
    protected $table = 'product_types';
    protected $fillable =  [
        'type_id',
        'product_id',
    ];

    public function fillProductTypes(int $productId, int $typeId): ProductTypes
    {
        $this->type_id = $typeId;
        $this->product_id = $productId;
        return $this;
    }
}
