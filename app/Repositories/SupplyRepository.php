<?php

namespace App\Repositories;

use App\Http\Requests\SupplyAddFormRequest;
use App\Interfaces\SupplyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Supply;

class SupplyRepository implements SupplyRepositoryInterface
{

    public function getAll(): Collection
    {
        return Supply::all();
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
     * Return all data with array 0 is_init false or true
     *
     * @return Collection<Supply>
     */
    public function getAllWithInit(): Collection
    {
        $supplies = $this->getAll();

        if(count($supplies) > 0) {
            $supplies[0]['is_init'] = true;
        }

        return $supplies;
    }

    public function delete($id)
    {
        return Supply::where('id', $id)->delete();
    }

    public function store(SupplyAddFormRequest $request)
    {
        $supply = new Supply();
        $supply->name = $request->name;
        $supply->cnpj = $request->cnpj;

        $supply->save();
    }
}
