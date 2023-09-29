<?php

namespace App\Models;

use App\Http\Requests\SupplyAddFormRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    use HasFactory;
    protected $table = 'fornecedores';
    protected $fillable = [
        'name',
        'cnpj'
    ];


    public function fillSupply(SupplyAddFormRequest $request): Supply
    {
        $this->name = $request->name;
        $this->cnpj = $request->cnpj;
        return $this;
    }
}
