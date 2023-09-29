<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplyAddFormRequest;
use App\Http\Requests\SupplyDeleteFormRequest;
use Illuminate\Http\Request;
use App\Repositories\SupplyRepository;
use App\Http\Requests\SupplyFormRequest;
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
        $supplyRepository->store($request);
        return redirect()->route('supply.index');
    }

}
