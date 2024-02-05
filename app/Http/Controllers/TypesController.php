<?php

namespace App\Http\Controllers;

use App\Http\Requests\Type\TypesAddFormRequest;
use App\Http\Requests\Type\TypesDeleteFormRequest;
use App\Http\Requests\Type\TypesEditFormRequest;
use App\Http\Requests\Type\TypesFormRequest;
use App\Http\Requests\Type\TypesUpdateFormRequest;
use App\Http\Resources\TypesResource;
use App\Repositories\ClientRepository;
use App\Repositories\TypesRepository;

class TypesController extends Controller
{   
    public function index(TypesRepository $typesRepository)
    {
        $types = $typesRepository->getAll();
        return view('pages.types.index', compact('types'));
    }

    public function find(TypesFormRequest $request, TypesRepository $typesRepository)
    {
        $search = $request->search;
        $types = $typesRepository->find($search);
        return view('pages.types.index',
            compact('types', 'search')
        );
    }

    public function delete(TypesDeleteFormRequest $request, TypesRepository $typesRepository )
    {
        $deleted= $typesRepository->delete($request->id);
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
        return view('pages.types.form');
    }

    public function store(TypesAddFormRequest $request, TypesRepository $typesRepository)
    {
        $saved = $typesRepository->store($request);
        return new TypesResource(['saved' => $saved]);
    }



    /**
     * Open view to edit a specific type 
     * @param TypeEditFormRequest $request,
     * @param TypesRepository $typesRepository
     * 
     * @return View
     */
    public function edit(TypesEditFormRequest $request, TypesRepository $typesRepository)
    {
        $type = $typesRepository->get($request->id);
        return view('pages.types.form', compact('type'));
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
