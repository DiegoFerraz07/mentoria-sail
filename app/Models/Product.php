<?php

namespace App\Models;

use App\Http\Requests\Product\ProductAddFormRequest;
use App\Http\Requests\Product\ProductUpdateFormRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;
    protected $table = 'produtos';
    protected $fillable =  [
        'nome',
        'valor',
        'brand_id',
    ];

    public function types(): BelongsToMany
    {
        return $this->belongsToMany(Types::class, 'product_types', 'product_id', 'type_id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function getProductPesquisarIndex(string $search = '')
    {
        $Product = $this->where(function ($query) use ($search){
            if ($search) {
                $query->where('nome', $search); 
                $query->orWhere('nome', 'LIKE', "%{$search}%");
            }
        })->get();

        return $Product;
    }

    public function fillProduct(ProductAddFormRequest|ProductUpdateFormRequest $request): Product
    {
        $this->nome = $request->nome;
        $this->valor = $request->valor;
        $this->brand_id = $request->brandId;
        return $this;
    }
}
