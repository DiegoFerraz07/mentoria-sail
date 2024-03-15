<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBrand extends Model
{
    use HasFactory;
    protected $table = 'product_brand';
    protected $fillable =  [
        'brand_id',
        'product_id',
    ];

    public function fillProductBrand(int $productId, int $brandId): ProductBrand
    {
        $this->brand_id = $brandId;
        $this->product_id = $productId;
        return $this;
    }
}
