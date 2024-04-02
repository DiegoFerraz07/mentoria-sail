<?php

namespace App\Http\Controllers;

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

    public function store(){
        
    }

}