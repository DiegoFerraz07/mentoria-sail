<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductAddFormRequest;
use App\Http\Requests\Product\ProductDeleteFormRequest;
use App\Http\Requests\Product\ProductEditFormRequest;
use App\Http\Requests\Product\ProductFormRequest;
use App\Http\Requests\Product\ProductUpdateFormRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Types;
use App\Repositories\ProductRepository;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(ProductRepository $productRepository)
    {
        $customers = $productRepository->getAll();
        return view('pages.produtos.index', compact('customers'));
    }

    public function find(ProductFormRequest $request, ProductRepository $productRepository)
    {
        $search = $request->search;
        $customers = $productRepository->find($search);
        return view('pages.produtos.index',
            compact('customers', 'search')
        );
    }

    /**
     * Delete specif product
     * 
     * @param ProductDeleteFormRequest $request
     * @param ProductRepository $productRepository
     * 
     */
    public function delete(ProductDeleteFormRequest $request ,ProductRepository $productRepository) 
    {
        $deleted= $productRepository->delete($request->id);
        if($deleted){
            return response()->json([
                'success' => true
            ]);
        }
        return response()->json([
            "success" => false
        ]);
    }

    public function add()
    {
        // TODO: corrigir para coloca repositories para trazer somente o name e o id
        $types = Types::all();
        return view('pages.produtos.form', compact('types'));
    }

     /**
     * Store a new product
     * 
     * @param ProductAddFormRequest $request, 
     * @param ProductRepository $productRepository
     * 
     * @return View
     */
    public function store(ProductAddFormRequest $request, ProductRepository $productRepository)
    {
        // TODO: salvei um produto eu tenho que retornar nesse save o id desse produto
        $saved = $productRepository->store($request);

        
        // TODO: pegar o id do type na request salvar com o id do produto e do type na tabela  ProductType
        // TODO: criar product type repository para salvar

        return new ProductResource(['saved' => $saved]);
    }

    /**
     * Open view to edit a specific Product
     * 
     * @return View
     */
    public function edit(ProductEditFormRequest $request, ProductRepository $productRepository)
    {
        // TODO: corrigir para coloca rrepositories
        $types = Types::all();
        $product = $productRepository->get($request->id);
        return view('pages.produtos.form', compact('product', 'types'));
    }

      /**
     * Update a Product
     * 
     * @param ProductUpdateFormRequest $request, 
     * @param ProductRepository $productRepository
     * 
     * @return Json
     */
    public function update(ProductUpdateFormRequest $request, ProductRepository $productRepository)
    {
        $updated = $productRepository->update($request);
        if($updated) {
            return response()->json([
                'success' => true
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Erro ao tentar salvar'
        ]);
    }

}
