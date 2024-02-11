<?php

namespace App\Repositories;

use App\Http\Requests\Supply\SupplyAddFormRequest;
use App\Http\Requests\Supply\SupplyUpdateFormRequest;
use App\Interfaces\SupplyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Supply;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class SupplyRepository implements SupplyRepositoryInterface
{

    public function getAll(): LengthAwarePaginator
    {
        return Supply::all()
            ->sortByDesc('id')
            ->toQuery()
            ->paginate(10);
    }

    /**
     * find a supply by name or CNPJ and return first 10
     *
     * @param string $search
     *
     * @return Collection<Supply>
     */
    public function find(string $search): Collection
    {
        return Supply::where(function($q) use ($search) {
            $q->where("name", "LIKE", "%$search%")
                ->orWhere("cnpj", $search);
        })->limit(10)->get();
    }

    /**
     * Delete a specific supply
     * @param int $id
     * 
     * @return bool
     */
    public function delete(int $id): bool
    {
        $deleted = Supply::where('id', $id)
            ->delete();

        return $deleted 
            ? true 
            : false;
    }

    /**
     * Store a new supply
     * @param SupplyAddFormRequest $request
     * 
     * @return bool
     */
    public function store(SupplyAddFormRequest $request): array
    {
        try {
            $supply = new Supply();
            $supply->fillSupply($request);
            $saved = $supply->save();
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
     * get a specific supply
     * @param int $id
     * 
     * @return Supply|null
     */
    public function get(int $id): Supply|null
    {
        return Supply::where('id', $id)->first();
    }


    /**
     * Store a new supply
     * @param SupplyAddFormRequest $request
     * 
     * @return bool
     */
    public function update(SupplyUpdateFormRequest $request): bool
    {
        try {
            $supply = $this->get($request->id);
            $supply->fillSupply($request);
            return $supply->update();
        } catch(Exception $e) {
            Log::error($e->getMessage() . $e->getTraceAsString());
            return false;
        }
    }

    
    /**
     * get cnpj attribute by od
     * @param int $id
     * 
     * @return string
     * 
     */
    public static function getCNPJById(int $id): string
    {
        $supply = Supply::select('cnpj')
            ->where(['id' => $id])
            ->first();

        if($supply) {
            return $supply->cnpj;
        }
        return "";
    }

    /**
     * Verify exist cnpj in diferents $ids
     * @param int $id
     * @param string $newCnpj
     * 
     * @return bool
     * 
     */
    public static function isOthersCNPJById(int $id, string $newCnpj): bool
    {
        $exist = Supply::where(['cnpj' => $newCnpj])
            ->where('id', '!=', $id)
            ->first();

        if($exist) {
            return true;
        }
        return false;
    }
}
