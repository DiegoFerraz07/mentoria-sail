<?php

namespace App\Models;

use App\Http\Requests\ClientAddFormRequest;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = 'cliente';
    protected $fillable = [
        'name',
        'cpf',
        'data',
    ];


    public function fillClient(ClientAddFormRequest $request): Client
    {
        $this->name = $request->name;
        $this->cpf = $request->cpf;
        $this->date = $request->date;
        return $this;
    }
}
