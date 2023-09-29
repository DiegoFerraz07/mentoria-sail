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
                required
                placeholder="Nome">
        </div>
        <div class="form-group">
            <label for="cnpj">CNPJ</label>
            <input type="text"
                class="form-control cnpj"
                name="cnpj"
                maxlength="18"
                minlength="18"
                data-mask="00.000.000/0000-00"
                id="cnpj"
                required
                placeholder="CNPJ">
        </div>
        <button type="submit" class="btn btn-success mt-2">Salvar</button>
    </form>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#cnpj').mask('00.000.000/0000-00', {reverse: true});
    });
    </script>
@endsection

