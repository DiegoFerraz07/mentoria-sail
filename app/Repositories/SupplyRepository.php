<?php

namespace App\Repositories;

use App\Interfaces\SupplyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Supply;

class SupplyRepository implements SupplyRepositoryInterface
{

    public function getAll()
    {
        return Supply::all();
    }

    /**
     * Return all data with array 0 is_init false or true
     * 
     * @return Supply
     */
    public function getAllWithInit(): Collection
    {
        $supplies = $this->getAll();

        if(count($supplies) > 0) {
            $supplies[0]['is_init'] = true;
        }
        
        return $supplies;
    }
}
