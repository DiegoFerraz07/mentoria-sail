<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\OrdersEditFormRequest;
use App\Http\Requests\Orders\OrdersFormRequest;
use App\Repositories\ClientRepository;
use App\Repositories\OrdersRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SupplyRepository;

class OrdersController extends Controller
{
    public function index(OrdersRepository $ordersRepository)
    {
        $orders = $ordersRepository->getAll();
        return view('pages.orders.index', compact('orders'));
    }

    public function find(OrdersFormRequest $request, OrdersRepository $ordersRepository)
    {
        $search = $request->search;
        $order = $ordersRepository->find($search);
        return view('pages.orders.index',
            compact('order', 'search')
        );
    }

    public function add(
        ClientRepository $clientRepository, 
        SupplyRepository $supplyRepository, 
        ProductRepository $productRepository
        )
    {
        $clients = $clientRepository->getAll();
        $supplys = $supplyRepository->all();
        $products = $productRepository->getAll();
        return view('pages.orders.form', compact('clients', 'supplys', 'products'));
    }

    public function edit(OrdersEditFormRequest $request, OrdersRepository $ordersRepository)
    {
        $orders = $ordersRepository->get($request->id);
        return view('pages.orders.form', compact('orders'));
    }

}