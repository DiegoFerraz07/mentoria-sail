<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Type\TypesAddFormRequest;
use App\Http\Requests\Type\TypesDeleteFormRequest;
use App\Http\Requests\Type\TypesEditFormRequest;
use App\Http\Requests\Type\TypesFormRequest;
use App\Http\Requests\Type\TypesUpdateFormRequest;
use App\Http\Resources\TypesResource;
use App\Repositories\TypesRepository;
use Illuminate\Http\Resources\Json\JsonResource;

class TypesController extends Controller
{   
    public function index(TypesRepository $typesRepository)
    {
        $types = $typesRepository->getAll();
        return JsonResource::collection($types);
    }

    public function allTypes(TypesRepository $typesRepository)
    {
        $types = $typesRepository->getAllForTypes();
        return $types;
    }

    public function find(TypesFormRequest $request, TypesRepository $typesRepository)
    {
        $search = $request->search;
        $types = $typesRepository->find($search);
        return JsonResource::collection($types);
    }

    public function delete(TypesDeleteFormRequest $request, TypesRepository $typesRepository )
    {
        $deleted= $typesRepository->delete($request->id);
        $collection = collect([
            'success' => $deleted
        ]);
        return new JsonResource($collection);
    }


    public function store(TypesAddFormRequest $request, TypesRepository $typesRepository)
    {
        $saved = $typesRepository->store($request);
        return new TypesResource(['saved' => $saved]);
    }


    /**
     * Update a type
     * 
     * @param TypeUpdateFormRequest $request, 
     * @param TYpesRepository $typesRepository
     * 
     * @return Json
     */
    public function update(TypesUpdateFormRequest $request, TYpesRepository $typesRepository)
    {
        $updated = $typesRepository->update($request);
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
