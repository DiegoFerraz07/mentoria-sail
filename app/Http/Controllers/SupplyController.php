<?php

namespace App\Http\Controllers;

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
}
