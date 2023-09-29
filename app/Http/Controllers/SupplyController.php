<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplyAddFormRequest;
use App\Http\Requests\SupplyDeleteFormRequest;
use Illuminate\Http\Request;
use App\Repositories\SupplyRepository;
use App\Http\Requests\SupplyFormRequest;

class SupplyController extends Controller
{

    public function index(SupplyRepository $supplyRepository)
    {
        $supplies = $supplyRepository->getAllWithInit();
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
        $supplyRepository->delete($request->idForne);
        return response()->json([
            'success' => true
        ]);
    }

    public function add()
    {
        return view('pages.fornecedores.form');
    }

    public function store(SupplyAddFormRequest $request, SupplyRepository $supplyRepository)
    {
        $supplyRepository->store($request);
        return redirect()->route('supply.index');
    }

}
