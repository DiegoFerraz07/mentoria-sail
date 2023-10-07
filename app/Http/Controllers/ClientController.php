<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\ClientDeleteFormRequest;
use App\Http\Requests\ClientAddFormRequest;
use App\Http\Requests\ClientFormRequest;
use App\Http\Requests\SupplyDeleteFormRequest;
use App\Models\Client;
use App\Repositories\ClientRepository;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(ClientRepository $clientRepository)
    {
        $customers = $clientRepository->getAll();
        return view('pages.clientes.index', compact('customers'));
    }

    public function find(ClientFormRequest $request, ClientRepository $clientRepository)
    {
        $search = $request->search;
        $customers = $clientRepository->find($search);
        return view('pages.clientes.index',
            compact('customers', 'search')
        );
    }

    public function delete(ClientDeleteFormRequest $request, ClientRepository $clientRepository )
    {
        $deleted= $clientRepository->delete($request->id);
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
        return view('pages.clientes.form');
    }

    public function store(ClientAddFormRequest $request, ClientRepository $clientRepository)
    {
        $saved = $clientRepository->store($request);
        if ($saved){
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
