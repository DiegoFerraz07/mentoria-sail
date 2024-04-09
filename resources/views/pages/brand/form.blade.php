@extends('layouts.app', ['activePage' => 'brand', 'title' => 'Add Brand', 'navName' => 'brand', 'activeButton' => 'brand'])

@section('content')
  <form-brand :brand-prop="{{ isset($brand) ? json_encode($brand) : json_encode([]) }}" />
@endsection
