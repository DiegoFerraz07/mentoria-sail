<?php

namespace App\Repositories;

use App\Http\Requests\SupplyAddFormRequest;
use App\Interfaces\SupplyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Supply;
use Exception;
use Illuminate\Support\Facades\Log;

class SupplyRepository implements SupplyRepositoryInterface
{

    public function getAll(): Collection
    {
        return Supply::all()
            ->sortByDesc('id');
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
     * @return void
     */
    public function store(SupplyAddFormRequest $request): void
    {
        try {
            $supply = new Supply();
            $supply->fillSupply($request)
                ->save();
        } catch(Exception $e) {
            Log::error($e->getMessage() . $e->getTraceAsString());
            return;
        }
    }
}
