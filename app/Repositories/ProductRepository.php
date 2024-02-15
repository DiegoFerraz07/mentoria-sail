<?php

namespace App\Repositories;

use App\Http\Requests\Product\ProductAddFormRequest;
use App\Http\Requests\Product\ProductUpdateFormRequest;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Log;

class ProductRepository implements ProductRepositoryInterface
{

    public function getAll(): Collection
    {
        return Product::all()
            ->sortByDesc('id');
    }

      /**
     * get a specific product
     * @param int $id
     *
     * @return Product|null
     */
    public function get(int $id): Product|null
    {
        return Product::where('id', $id)->first();
    }

    /**
     * find a product by nome or id and return first 10
     *
     * @param string $search
     *
     * @return Collection<Product>
     */
    public function find(string $search): Collection
    {
        return Product::where(function($q) use ($search) {
            $q->where("nome", "LIKE", "%$search%")
                ->orWhere("id", $search);
        })->limit(10)
        ->get();
    }

    /**
     * Delete a specific product
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        $deleted = Product::where('id', $id)
            ->delete();

        return $deleted
            ? true
            : false;
    }

     /**
     * Store a new Product
     * @param ProductAddFormRequest $request
     *
     * @return array
     */
    public function store(ProductAddFormRequest $request): array
    {
        try {
            $product = new Product();
            $product->fillProduct($request);
            $saved = $product->save();
            return array(
                'success' => $saved,
                'message' => ''
            );
        } catch(Exception $e) {
            $message = 'Houve um erro';
            /*if($e->getMessage() && str_contains($e->getMessage(), 'cliente_cpf_unique')) {
                $message = 'Já existe um cliente com esse CPF';
            }*/
            Log::error($e->getMessage() . $e->getTraceAsString());
            return array(
                'success' => false,
                'message' => $message
            );
        }
    }

     /**
     * Update a product
     * @param ProductUpdateFormRequest $request
     * 
     * @return bool
     */
    public function update(ProductUpdateFormRequest $request): bool
    {
        try {
            $product = $this->get($request->id);
            $product->fillProduct($request);
            return $product->update();
        } catch(Exception $e) {
            Log::error($e->getMessage() . $e->getTraceAsString());
            return false;
        }
    }



}
