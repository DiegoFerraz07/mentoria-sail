@extends('layouts.app', ['activePage' => 'dashboard', 'title' => 'Light Bootstrap Dashboard Laravel by Creative Tim & UPDIVISION', 'navName' => 'Dashboard', 'activeButton' => 'laravel'])

@section('content')
    <form-product 
        :products-prop="{{ isset($products) ? json_encode($products) : json_encode([]) }}" 
        :product-types-prop="{{ isset($productTypes) ? json_encode($productTypes) : json_encode([]) }}"
    />
@endsection

