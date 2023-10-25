<?php

namespace App\Models;

use App\Http\Requests\Supply\SupplyAddFormRequest;
use App\Http\Requests\Supply\SupplyUpdateFormRequest;
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


    public function fillSupply(SupplyAddFormRequest|SupplyUpdateFormRequest $request): Supply
    {
        $this->name = $request->name;
        $this->cnpj = $request->cnpj;
        return $this;
    }
}
