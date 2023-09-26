<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupplyController extends Controller
{
    
    public function index()
    {
        //$fornecedores = ->getProdutosPesquisarIndex(search: $pesquisar ?? '');

        return view('pages.produtos.paginacao', compact('findProduto'));

    }
}
