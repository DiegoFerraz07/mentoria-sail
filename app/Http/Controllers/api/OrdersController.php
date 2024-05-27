<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\OrdersAddFormRequest;
use App\Http\Requests\Orders\OrdersDeleteFormRequest;
use App\Http\Requests\Orders\OrdersFormRequest;
use App\Http\Resources\OrdersResource;
use App\Repositories\OrdersRepository;
use Illuminate\Http\Resources\Json\JsonResource;




class OrdersController extends Controller
{

    public function index(
        OrdersRepository $ordersRepository
    ) {
        $orders = $ordersRepository->getAll();
        return JsonResource::collection($orders); 
    }

    public function find(OrdersFormRequest $request, OrdersRepository $ordersRepository)
    {
        $search = $request->search;
        $products = $ordersRepository->find($search);
        return JsonResource::collection($products);
    }

    /**
     * Delete specif orders
     * 
     * @param OrdersDeleteFormRequest $request
     * @param OrdersRepository $productRepository
     * 
     */
    public function delete(OrdersDeleteFormRequest $request, OrdersRepository $ordersRepository)
    {
        $deleted = $ordersRepository->delete($request->id);
        // create collection with response
        $collection = collect([
            'success' => $deleted
        ]);
        return new JsonResource($collection);
    }

    
     /**
     * Store a new orders
     * 
     * @param OrdersAddFormRequest $request, 
     * @param OrdersRepository $ordersRepository
     * 
     * @return View
     */
    public function store(OrdersAddFormRequest $request, OrdersRepository $ordersRepository)
    {
        $saved = $ordersRepository->store($request);
        return new OrdersResource(['saved' => $saved]);
    }

}
