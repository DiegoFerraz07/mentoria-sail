<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductAddFormRequest;
use App\Http\Requests\Product\ProductDeleteFormRequest;
use App\Http\Requests\Product\ProductFormRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\ProductRepository;
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
        return view('pages.produtos.form');
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
        $saved = $productRepository->store($request);
        return new ProductResource(['saved' => $saved]);
    }

}
