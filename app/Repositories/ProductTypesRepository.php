<?php

namespace App\Repositories;

use App\Http\Requests\ProductTypes\ProductTypesAddFormRequest;
use App\Interfaces\ProductTypesRepositoryInterface;
use App\Models\ProductTypes;
use Exception;
use Illuminate\Support\Facades\Log;

class ProductTypesRepository implements ProductTypesRepositoryInterface
{
    public function store( ProductTypesAddFormRequest $request): array
    {
        try {
            $productTypes = new ProductTypes();
            $productTypes->fillProductTypes($request);
            $saved = $productTypes->save();
            return array(
                'success' => $saved,
                'message' => '',
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
}