<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct(private Client $cliente) {}

    public function index(Request $request)
    {
        $pesquisar = $request->pesquisar;
        $findClient = $this->cliente->getProdutosPesquisarIndex(search: $pesquisar ?? '');

        return view('pages.clientes.index', compact('findClient'));
    }

    public function delete(Request $request)
    {
        return response()->json(['success' => true]);
    }
}
