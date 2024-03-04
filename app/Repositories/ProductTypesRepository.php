<?php

namespace App\Repositories;

use App\Http\Requests\ProductTypes\ProductTypesAddFormRequest;
use App\Interfaces\ProductTypesRepositoryInterface;
use App\Models\ProductTypes;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class ProductTypesRepository implements ProductTypesRepositoryInterface
{
    public function store(int $productId, array $typesId): array
    {
        try {
            foreach($typesId as $typeId) {  
                $productTypes = new ProductTypes();
                $productTypes->fillProductTypes($productId, $typeId);
                $saved = $productTypes->save();

                if(!$saved) {
                    throw new Exception('Erro ao tetar salvar o tipo do produto: ' . $typeId . ' para o produto: ' . $productId . ' na tabela produtos_types');
                }
            }

            return array(
                'success' => $saved,
                'message' => '',
            );
        } catch(Exception $e) {
            $message = 'Houve um erro';
            if($e->getMessage()) {
                $message = $e->getMessage();
            }
            Log::error($e->getMessage() . $e->getTraceAsString());
            return array(
                'success' => false,
                'message' => $message
            );
        }
    }

     
    public function getID(int $productId): ProductTypes|null
    {
        return ProductTypes::select('product_id', $productId);
        
    }
}   