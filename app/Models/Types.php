<?php

namespace App\Models;

use App\Http\Requests\Type\TypesAddFormRequest;
use App\Http\Requests\Type\TypesUpdateFormRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Types extends Model
{
    use HasFactory;

    protected $table = 'types';

    public function fillType(TypesAddFormRequest|TypesUpdateFormRequest $request): Types
    {
        $this->name = $request->name;
        $this->description = $request->description;
        return $this;
    }
}
