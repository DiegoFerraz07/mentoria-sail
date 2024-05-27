<?php

namespace App\Repositories;

use App\Http\Requests\Orders\OrdersAddFormRequest;
use App\Http\Requests\Orders\OrdersUpdateFormRequest;
use App\Interfaces\OrdersRepositoryInterface;
use App\Models\Orders;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrdersRepository implements OrdersRepositoryInterface
{
    public function getAll(): LengthAwarePaginator|Collection
    {
        $orders = Orders::all()
            ->sortByDesc('id');

        if($orders->isEmpty()) {
            return $orders;
        }

        return $orders->toQuery()
          ->paginate(20);
    }

     /**
     * find a orders by name or CPf and return first 10
     *
     * @param string $search
     *
     * @return Collection<Orders>
     */
    public function find(string $search): Collection
    {
        return Orders::where(function($q) use ($search) {
            $q->where("numeroOrder", "LIKE", "%$search%")
                ->orWhere("nameClient", $search)
                ->orWhere("cpfClient", $search);
        })->limit(10)
        ->get();
    }

    public function delete(int $id): bool
    {
        $deleted = Orders::where('id', $id)
            ->delete();

        return $deleted
            ? true
            : false;
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

      /**
     * get a specific orders
     * @param int $id
     *
     * @return Orders|null
     */
    public function get(int $id): Orders|null
    {
        return Orders::where('id', $id)->first();
    }


    /**
     * get numero Order attribute by od
     * @param int $id
     * 
     * @return string
     * 
     */
    public static function getNumeroOrderById(int $id): string
    {
        $orders = Orders::select('numeroOrder')
        ->where(['id' => $id])
            ->first();

        if ($orders && $orders->numeroOrder) {
            return $orders->numeroOrder;
        }
        return "";
    }


    /**
     * Verify exist numero Order in diferents $ids
     * @param int $id
     * @param string $newNumeroOrder
     * 
     * @return bool
     * 
     */
    public static function isOthersNumeroOrderById(int $id, string $newNumeroOrder): bool
    {
        $exist = Orders::where(['numeroOrder' => $newNumeroOrder])
            ->where('id', '!=', $id)
            ->first();

        if ($exist) {
            return true;
        }
        return false;
    }
}
