<?php

namespace App\Http\Controllers;

use App\Http\Requests\Brand\BrandAddFormRequest;
use App\Http\Requests\Brand\BrandDeleteFormRequest;
use App\Http\Requests\Brand\BrandEditFormRequest;
use App\Http\Requests\Brand\BrandFormRequest;
use App\Http\Requests\Brand\BrandUpdateFormRequest;
use App\Http\Resources\BrandResource;
use App\Repositories\BrandRepository;

class BrandController extends Controller
{   
    public function index(BrandRepository $brandRepository)
    {
        $brands = $brandRepository->getAll();
        return view('pages.brand.index', compact('brands'));
    }

    public function find(BrandFormRequest $request, BrandRepository $brandRepository)
    {
        $search = $request->search;
        $brand = $brandRepository->find($search);
        return view('pages.brand.index',
            compact('brand', 'search')
        );
    }

    public function add()
    {
        return view('pages.brand.form');
    }

    public function store(BrandAddFormRequest $request, BrandRepository $brandRepository)
    {
        $saved = $brandRepository->store($request);
        return new BrandResource(['saved' => $saved]);
    }

    public function delete(BrandDeleteFormRequest $request, BrandRepository $brandRepository )
    {
        $deleted= $brandRepository->delete($request->id);
        if($deleted){
            return response()->json([
                'success' => true
            ]);
        }
        return response()->json([
            "success" => false
        ]);
    }

    /**
     * Open view to edit a specific brand 
     * @param BrandEditFormRequest $request,
     * @param BrandRepository $brandRepository
     * 
     * @return View
     */
    public function edit(BrandEditFormRequest $request, BrandRepository $brandRepository)
    {
        $brand = $brandRepository->get($request->id);
        return view('pages.brand.form', compact('brand'));
    }


    /**
     * Update a brand
     * 
     * @param BrandUpdateFormRequest $request, 
     * @param BrandRepository $brandRepository
     * 
     * @return Json
     */
    public function update(BrandUpdateFormRequest $request, BrandRepository $brandRepository)
    {
        $updated = $brandRepository->update($request);
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
