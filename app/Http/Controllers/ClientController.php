<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\ClientDeleteFormRequest;
use App\Http\Requests\Client\ClientAddFormRequest;
use App\Http\Requests\Client\ClientEditFormRequest;
use App\Http\Requests\Client\ClientFormRequest;
use App\Http\Requests\Client\ClientUpdateFormRequest;
use App\Http\Resources\ClientResource;
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
        return new ClientResource(['saved' => $saved]);
    }

    public function edit(ClientEditFormRequest $request, ClientRepository $clientRepository)
    {
        $client = $clientRepository->get($request->id);
        return view('pages.clientes.form', compact('client'));
    }


    /**
     * Update a client
     *
     * @param ClientUpdateFormRequest $request,
     * @param ClientRepository $clientRepository
     *
     * @return Json
     */
    public function update(ClientUpdateFormRequest $request, ClientRepository $clientRepository)
    {
        $updated = $clientRepository->update($request);
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
