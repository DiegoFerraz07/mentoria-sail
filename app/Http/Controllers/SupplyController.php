<?php

namespace App\Http\Controllers;

use App\Http\Requests\Supply\SupplyAddFormRequest;
use App\Http\Requests\Supply\SupplyDeleteFormRequest;
use App\Http\Requests\Supply\SupplyEditFormRequest;
use App\Repositories\SupplyRepository;
use App\Http\Requests\Supply\SupplyFormRequest;
use App\Http\Requests\Supply\SupplyUpdateFormRequest;
use App\Http\Resources\SupplyResource;
use App\Models\Supply;

class SupplyController extends Controller
{

    public function index(SupplyRepository $supplyRepository)
    {
        $supplies = $supplyRepository->getAll();
        return view('pages.fornecedores.index', compact('supplies'));
    }

    public function find(SupplyFormRequest $request, SupplyRepository $supplyRepository)
    {
        $search = $request->search;
        $supplies = $supplyRepository->find($search);
        return view('pages.fornecedores.index',
            compact('supplies', 'search')
        );
    }

    public function delete(SupplyDeleteFormRequest $request, SupplyRepository $supplyRepository)
    {
        $deleted = $supplyRepository->delete($request->idForne);
        if($deleted) {
            return response()->json([
                'success' => true
            ]);
        }
        return response()->json([
            'success' => false
        ]);
    }

    /**
     * Open view to add a new Supply 
     * 
     * @return View
     */
    public function add()
    {
        return view('pages.fornecedores.form');
    }

    /**
     * Store a new supply
     * 
     * @param SupplyAddFormRequest $request, 
     * @param SupplyRepository $supplyRepository
     * 
     * @return View
     */
    public function store(SupplyAddFormRequest $request, SupplyRepository $supplyRepository)
    {
        $saveAndMessage = $supplyRepository->store($request);
        return new SupplyResource(['saveAndMessage' => $saveAndMessage]);
    }


    /**
     * Open view to edit a specific Supply 
     * 
     * @return View
     */
    public function edit(SupplyEditFormRequest $request, SupplyRepository $supplyRepository)
    {
        $supply = $supplyRepository->get($request->id);
        return view('pages.fornecedores.form', compact('supply'));
    }


    /**
     * Update a supply
     * 
     * @param SupplyUpdateFormRequest $request, 
     * @param SupplyRepository $supplyRepository
     * 
     * @return Json
     */
    public function update(SupplyUpdateFormRequest $request, SupplyRepository $supplyRepository)
    {
        $updated = $supplyRepository->update($request);
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
