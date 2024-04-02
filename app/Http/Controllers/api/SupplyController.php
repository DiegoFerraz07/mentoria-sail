<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supply\SupplyAddFormRequest;
use App\Http\Requests\Supply\SupplyDeleteFormRequest;
use App\Http\Requests\Supply\SupplyEditFormRequest;
use App\Repositories\SupplyRepository;
use App\Http\Requests\Supply\SupplyFormRequest;
use App\Http\Requests\Supply\SupplyUpdateFormRequest;
use App\Http\Resources\SupplyResource;
use App\Models\Supply;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplyController extends Controller
{

    public function index(SupplyRepository $supplyRepository)
    {
        $supplies = $supplyRepository->getAll();
        return JsonResource::collection($supplies);
    }

    public function find(SupplyFormRequest $request, SupplyRepository $supplyRepository)
    {
        $search = $request->search;
        $supplies = $supplyRepository->find($search);
        return JsonResource::collection($supplies);
    }

    public function delete(SupplyDeleteFormRequest $request, SupplyRepository $supplyRepository)
    {
        $deleted = $supplyRepository->delete($request->idForne);
        // create collection with response
        $collection = collect([
            'success' => $deleted
        ]);
        return new JsonResource($collection);
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
        $saveAndMessage = $supplyRepository->store($request);
        return new SupplyResource(['saveAndMessage' => $saveAndMessage]);
    }

    /**
     * Update a supply
     * 
     * @param SupplyUpdateFormRequest $request, 
     * @param SupplyRepository $supplyRepository
     * 
     * @return Json
     */
    public function update(SupplyUpdateFormRequest $request, SupplyRepository $supplyRepository)
    {
        $updated = $supplyRepository->update($request);
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
