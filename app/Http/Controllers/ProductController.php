<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductAddFormRequest;
use App\Http\Requests\Product\ProductDeleteFormRequest;
use App\Http\Requests\Product\ProductEditFormRequest;
use App\Http\Requests\Product\ProductFormRequest;
use App\Http\Requests\Product\ProductUpdateFormRequest;
use App\Http\Resources\ProductResource;
use App\Jobs\NewProductJob;
use App\Mail\UserNewProduct;
use App\Repositories\ClientRepository;
use App\Repositories\BrandRepository;
use App\Repositories\ProductBrandRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ProductTypesRepository;
use App\Repositories\TypesRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use function Laravel\Prompts\select;

class ProductController extends Controller
{

    public function index(ProductRepository $productRepository,)
    {
        $products = $productRepository->getAll();
        return view('pages.produtos.index', compact('products'));
    }

    public function find(ProductFormRequest $request, ProductRepository $productRepository)
    {
        $search = $request->search;
        $products = $productRepository->find($search);
        return view(
            'pages.produtos.index',
            compact('products', 'search')
        );
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
        if ($deleted) {
            return response()->json([
                'success' => true
            ]);
        }
        return response()->json([
            "success" => false
        ]);
    }

    public function add(TypesRepository $typesRepository, BrandRepository $brandRepository)
    {
        $brands = $brandRepository->all();
        $types = $typesRepository->all();
        $productTypes = [];
        return view('pages.produtos.form', compact('types', 'productTypes', 'brands'));
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
     * Open view to edit a specific Product
     * 
     * @return View
     */
    public function edit(
        ProductEditFormRequest $request,
        ProductRepository $productRepository,
        TypesRepository $typesRepository,
        ProductTypesRepository $productTypesRepository,
        BrandRepository $brandRepository
    ) {
        $types = $typesRepository->all();
        $brands = $brandRepository->all();
        $products = $productRepository->get($request->id);
        $productTypes = $productTypesRepository->getTypeIdByProductId($request->id);
        return view('pages.produtos.form', compact('products', 'types', 'productTypes', 'brands'));
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
