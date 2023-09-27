<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\SupplyRepository;

class SupplyController extends Controller
{

    public function index(SupplyRepository $supplyRepository)
    {
        $supplies = $supplyRepository->getAllWithInit();
        return view('pages.fornecedores.index', compact('supplies'));
    }
}
