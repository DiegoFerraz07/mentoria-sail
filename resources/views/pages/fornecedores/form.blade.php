{{-- Extends da index --}}
@extends('index')

@section('content')
    <form>
        <div class="form-group">
            <label for="name">Nome</label>
            <input type="text" 
                class="form-control" 
                id="name" 
                placeholder="Nome">
        </div>
        <div class="form-group">
            <label for="cnpj">CNPJ</label>
            <input type="text" 
                class="form-control" 
                id="cnpj" 
                placeholder="CNPJ">
        </div>
        <button type="submit" class="btn btn-success mb-2">alvar</button>
    </form>
@endsection
