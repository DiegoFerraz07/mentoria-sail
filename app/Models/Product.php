<?php

namespace App\Models;

use App\Http\Requests\Product\ProductAddFormRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'produtos';
    protected $fillable =  [
        'nome',
        'valor',
    ];

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

    public function fillProduct(ProductAddFormRequest $request): Product
    {
        $this->nome = $request->nome;
        $this->valor = $request->valor;
        return $this;
    }
}
