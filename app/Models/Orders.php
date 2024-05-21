<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $fillable = [
        'numero_order',
        'description_order',
        'tax_order',
        'icms_order',
        'total_value_order',
        'obs_order',
        'name_supply',
        'cnpj_supply',
        'name_client',
        'cpf_client',
        'cnpj_client',
        'address_client',
        'orders_itens'=> 'json',
    ];

    public function fillOrders($request) : Orders
    {
        $this->numero_order = $request->numeroOrder;
        $this->description_order = $request->descriptionOrder;
        $this->tax_order = $request->taxOrder;
        $this->icms_order = $request->icmsOrder;
        $this->total_value_order = $request->totalValueOrder;
        $this->obs_order = $request->obsOrder;
        $this->name_supply = $request->nameSupply;
        $this->cnpj_supply = $request->cnpjSupply;
        $this->name_client = $request->nameClient;
        $this->cpf_client = $request->cpfClient;
        $this->cnpj_client = $request->cnpjClient;
        $this->address_client = json_encode($request->addressClient);
        $this->orders_itens = json_encode($request->ordersItens);
        return $this;
    }
}
