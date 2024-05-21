<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ClientDeleteFormRequest;
use App\Http\Requests\Client\ClientAddFormRequest;
use App\Http\Requests\Client\ClientEditFormRequest;
use App\Http\Requests\Client\ClientFormRequest;
use App\Http\Requests\Client\ClientUpdateFormRequest;
use App\Http\Resources\ClientResource;
use App\Repositories\ClientRepository;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientController extends Controller

{   
    public function index(ClientRepository $clientRepository)
    {
        $customers = $clientRepository->getAll();
        return JsonResource::collection($customers);
    }

    public function find(ClientFormRequest $request, ClientRepository $clientRepository)
    {
        $search = $request->search;
        $customers = $clientRepository->find($search);
        return JsonResource::collection($customers);
    }

    public function delete(ClientDeleteFormRequest $request, ClientRepository $clientRepository )
    {
        $deleted= $clientRepository->delete($request->id);
        $collection = collect([
            'success' => $deleted
        ]);
        return new JsonResource($collection);
    }

     /**
     * Store a new client
     * 
     * @param ClientAddFormRequest $request, 
     * @param ClientRepository $clientRepository
     * 
     * @return View
     */
    public function store(ClientAddFormRequest $request, ClientRepository $clientRepository)
    {
        $saved = $clientRepository->store($request);
        return new ClientResource(['saved' => $saved]);
    }

    /**
     * Update a Client
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
