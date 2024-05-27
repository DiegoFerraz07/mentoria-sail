<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductAddFormRequest;
use App\Http\Requests\Product\ProductDeleteFormRequest;
use App\Http\Requests\Product\ProductFormRequest;
use App\Http\Requests\Product\ProductUpdateFormRequest;
use App\Http\Resources\ProductResource;
use App\Repositories\ClientRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ProductTypesRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;


use function Laravel\Prompts\select;

class ProductController extends Controller
{

    public function index(
        ProductRepository $productRepository
    )
    {
        $products = $productRepository->getAll();
        return JsonResource::collection($products); 
    }

    public function find(ProductFormRequest $request, ProductRepository $productRepository)
    {
        $search = $request->search;
        $products = $productRepository->find($search);
        return JsonResource::collection($products);
    }

    /**
     * Delete specif product
     * 
     * @param ProductDeleteFormRequest $request
     * @param ProductRepository $productRepository
     * 
     */
    public function delete(ProductDeleteFormRequest $request, ProductRepository $productRepository)
    {
        $deleted = $productRepository->delete($request->id);
        // create collection with response
        $collection = collect([
            'success' => $deleted
        ]);
        return new JsonResource($collection);
    }

    /**
     * Store a new product
     * 
     * @param ProductAddFormRequest $request, 
     * @param ProductRepository $productRepository
     * 
     * @return View
     */
    public function store(
        ProductAddFormRequest $request,
        ProductRepository $productRepository,
        ProductTypesRepository $productTypesRepository,
        ClientRepository $clientRepository
    ) {
        DB::beginTransaction();

        try {
            $saved = $productRepository->store($request);
            $productId = $saved['id'];
            if ($saved['success'] && $productId &&  $request['types']) {
                $saved = $productTypesRepository->store($productId, $request['types']);
            }
            if (!$saved || !$saved['success']) {
                DB::rollBack();
            } else {
                // envio de email para todos os clientes
                $clients = $clientRepository->getAllAsArray();
                $product = $productRepository->find($productId)[0];

                //  NewProductJob::dispatch($clients, $product)
                //    ->onQueue('emails');

                DB::commit();
            }

            return new ProductResource(['saved' => $saved]);
        } catch (\Exception $e) {
            DB::rollBack();
            $saved = array(
                'success' => false,
                'message' => $e->getMessage()
            );
            return new ProductResource(['saved' => $saved]);
        }
    }

    /**
     * Update a Product
     * 
     * @param ProductUpdateFormRequest $request, 
     * @param ProductRepository $productRepository
     * 
     * @return Json
     */
    public function update(ProductUpdateFormRequest $request, ProductRepository $productRepository, ProductTypesRepository $productTypesRepository)
    {

        //pegar todos da tabela product_types onde 
        // o product_id é o que vocês está editando
        // remove todos e 
        // depois salva de novo os que vieram na request



        DB::beginTransaction();

        try {
            $updated = $productRepository->update($request);
            if ($updated['success'] && $updated['id'] &&  $request['types']) {
                $deleted = $productTypesRepository->delete($request->id);
                if ($deleted) {
                    $updated = $productTypesRepository->store($updated['id'], $request['types']);
                } else {
                    $updated = false;
                }
            }

            if (!$updated || !$updated['success']) {
                DB::rollBack();
            } else {
                DB::commit();
            }

            return new ProductResource(['saved' => $updated]);
        } catch (\Exception $e) {
            DB::rollBack();
            $updated = array(
                'success' => false,
                'message' => $e->getMessage()
            );
            return new ProductResource(['updated' => $updated]);
        }
    }
}
