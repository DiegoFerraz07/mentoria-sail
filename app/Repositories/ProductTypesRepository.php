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

    /**
     * retorna uma lista de tipos de produtos
     * @param int $productId
     * 
     * @return array
     */
    public function getTypeIdByProductId(int $productId): array
    {
        /* select product_id  --- ->selec('')
        from  product_types ---- model
        join        ---- ->join('product_types', 'product_types.type_id', '=', 'types.id')
        where    ---- ->where('product_id', $productId) 
        orderby ---- ->orderBy('id', 'desc')
        */
        
        $types = ProductTypes::select('type_id')
            ->where('product_id', $productId)
            ->get()
            ->toArray();

        $types = array_column($types, 'type_id');
        return $types;
    }
}   