<?php

namespace App\Repositories;

use App\Http\Requests\Client\OrdersAddFormRequest;
use App\Interfaces\OrdersRepositoryInterface;
use App\Models\Orders;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrdersRepository extends OrdersRepositoryInterface
{
    public function getAll(): LengthAwarePaginator
    {
        return Orders::all()
          ->sortByDesc('id')
          ->toQuery()
          ->paginate(20);
    }

    public function store(OrdersAddFormRequest $request): array
    {
        try {
            $orders = new Orders();
            $orders->fillOrders($request);
            $saved = $orders->save();
            return array(
                'success' => $saved,
                'message' => ''
            );
        } catch(Exception $e) {
            $message = 'Houve um erro';
            if($e->getMessage() && str_contains($e->getMessage(), 'fornecedores_cnpj_unique')) {
                $message = 'Já existe um fornecedor com esse CNPJ';
            }
            Log::error($e->getMessage() . $e->getTraceAsString());
            return array(
                'success' => false,
                'message' => $message
            );
        }
    }
}
