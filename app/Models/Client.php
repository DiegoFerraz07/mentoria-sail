<?php

namespace App\Models;

use App\Http\Requests\Client\ClientAddFormRequest;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    
    const LEGAL_AGE = 18;
    
    protected $table = 'cliente';
    protected $fillable = [
        'name',
        'cpf',
        'date',
    ];

    protected $appends = ['date_formatted'];

    public function getDateFormattedAttribute()
    {
        return DateTime::createFromFormat('Y-m-d', $this->date)->format('d/m/Y');  
    }

    public function fillClient(ClientAddFormRequest $request): Client
    {
        $this->name = $request->name;
        $this->cpf = $request->cpf;
        $this->date = $request->date;
        return $this;
    }

}
