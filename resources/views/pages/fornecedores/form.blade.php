{{-- Extends da index --}}
@extends('index')

@section('content')
    <form method="POST" action="{{route('supply.store')}}">
        @csrf
        <div class="form-group">
            <label for="name">Nome</label>
            <input type="text"
                class="form-control"
                name="name"
                id="name"
                placeholder="Nome">
        </div>
        <div class="form-group">
            <label for="cnpj">CNPJ</label>
            <input type="text"
                class="form-control"
                name="cnpj"
                id="cnpj"
                placeholder="CNPJ">
        </div>
        <button type="submit" class="btn btn-success mb-2">Salvar</button>
    </form>
@endsection
