<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientFormRequest;
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

    public function delete(Request $request)
    {
        return response()->json(['success' => true]);
    }
}
