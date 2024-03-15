<?php

namespace App\Repositories;

use App\Http\Requests\Brand\BrandAddFormRequest;
use App\Http\Requests\Brand\BrandUpdateFormRequest;
use App\Interfaces\BrandRepositoryInterface;
use App\Models\Brand;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class BrandRepository implements BrandRepositoryInterface
{

    /**
     * Get all brands
     * @return LengthAwarePaginator
     */
    public function getAll(): LengthAwarePaginator
    {
        return Brand::all()
            ->sortByDesc('id')
            ->toQuery()
            ->paginate(20);
    }
    /**
    *Get all brands no restricion to numbers
    */
    public function all(): Collection
    {
        $brand = Brand::all('name', 'id');
        return $brand;
    }

    /**
     * get a specific brand
     * @param int $id
     * 
     * @return Brand|null
     */
    public function get(int $id): Brand|null
    {
        return Brand::where('id', $id)->first();
    }

    /**
     *
     * @param string $search
     *
     * @return LengthAwarePaginator<Brand>
     */
    public function find(string $search): LengthAwarePaginator
    {
        return Brand::where(function($q) use ($search) {
            $q->where("name", "LIKE", "%$search%")
                ->orWhere("description", "LIKE", $search);
        })->paginate(10);
    }


    /**
     * Store a new brand
     * @param BrandAddFormRequest $request
     *
     * @return array
     */
    public function store(BrandAddFormRequest $request): array
    {
        try {
            $brand = new Brand();
            $brand->fillBrand($request);
            $saved = $brand->save();
            return array(
                'success' => $saved,
                'message' => ''
            );
        } catch(Exception $e) {
            $message = 'Houve um erro';
            if($e->getMessage() && str_contains($e->getMessage(), 'cliente_cpf_unique')) {
                $message = 'Já existe um cliente com esse CPF';
            }
            Log::error($e->getMessage() . $e->getTraceAsString());
            return array(
                'success' => false,
                'message' => $message
            );
        }
    }

    /**
     * Delete a specific brand
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        $deleted = Brand::where('id', $id)
            ->delete();

        return $deleted
            ? true
            : false;
    }


    /**
     * Update a brand
     * @param BrandUpdateFormRequest $request
     * 
     * @return bool
     */
    public function update(BrandUpdateFormRequest $request): bool
    {
        try {
            $brand = $this->get($request->id);
            $brand->fillBrand($request);
            return $brand->update();
        } catch(Exception $e) {
            Log::error($e->getMessage() . $e->getTraceAsString());
            return false;
        }
    }

}
