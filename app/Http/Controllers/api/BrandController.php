<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Brand\BrandAddFormRequest;
use App\Http\Requests\Brand\BrandDeleteFormRequest;
use App\Http\Requests\Brand\BrandEditFormRequest;
use App\Http\Requests\Brand\BrandFormRequest;
use App\Http\Requests\Brand\BrandUpdateFormRequest;
use App\Http\Resources\BrandResource;
use App\Repositories\BrandRepository;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandController extends Controller

{   
    public function index(BrandRepository $brandRepository)
    {
        $brands = $brandRepository->getAll();
        return JsonResource::collection($brands);
    }

    public function allBrands(BrandRepository $brandRepository)
    {
        $brands = $brandRepository->all();
        return $brands;
    }

    public function find(BrandFormRequest $request, BrandRepository $brandRepository)
    {
        $search = $request->search;
        $brands = $brandRepository->find($search);
        return JsonResource::collection($brands);
    }

    public function store(BrandAddFormRequest $request, BrandRepository $brandRepository)
    {
        $saved = $brandRepository->store($request);
        return new BrandResource(['saved' => $saved]);
    }

    public function delete(BrandDeleteFormRequest $request, BrandRepository $brandRepository )
    {
        $deleted= $brandRepository->delete($request->id);
        $collection = collect([
            'success' => $deleted
        ]);
        return new JsonResource($collection);
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
