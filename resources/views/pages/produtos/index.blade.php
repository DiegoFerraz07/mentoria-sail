@extends('layouts.app', ['activePage' => 'dashboard', 'title' => 'Light Bootstrap Dashboard Laravel by Creative Tim & UPDIVISION', 'navName' => 'Dashboard', 'activeButton' => 'laravel'])

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Produtos</h1>
    </div>
    <div>
        <form action="{{ route('product.find') }}" method="POST">
            @csrf
            <input type="text" required minlength="3" value="{{$search ?? ''}}" name="search" placeholder="Digite o nome do produto" />
            <button> pesquisar </button>
            @if(isset($search))
                <a href="{{ route('product.index') }}" class="btn btn-danger btn-sm">
                    Limpar Pesquisa
                </a>
            @endif
        </form>
        <a type="button" href="{{route('product.add')}}" class="btn btn-success float-end">
            Adicionar
        </a>
        <div class="table-responsive mt-4">
            @if ($customers->isEmpty())
                <p> Não existe dados </p>
            @else
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Valor</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->nome }}</td>
                                <td>{{ 'R$' . ' ' . number_format($product->valor, 2, ',', '.') }}</td>
                                <td>
                                    <a href="{{route("product.edit", ['id' => $product->id])}}" class="btn btn-light btn-sm">
                                        Editar
                                    </a>

                                    <meta name='csrf-token' content="{{ csrf_token() }}"/>
                                    <button onclick="confirmDeleteSupply('{{$product->id}}', '{{$product->name}}')" class="btn btn-danger btn-sm">
                                        Excluir
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function confirmDeleteSupply(id, nome) {
        const alertSwal = window.alertSweet;
        alertSwal(
            `Deseja realmente excluir o produto <b>"${nome}"</b>?`, 
            'warning', 
            success => {
                this.deleteSupply(id);
            }
        );
    }

    function deleteSupply(id) {
        axios.delete('{{route("product.delete")}}', {
            data: {
                id: id,
            }
        })
        .then(response => {
            if(response.data.success) {
                alertSweet(
                    'Excluido com sucesso', 
                    'success',
                    success => {
                        document.location.reload();
                    }
                );
            }
        })
        .catch(error => {
            alertSweet(
                'Não foi possivel excluir!!',
                'error'
            )
        });
    }
</script>
@endsection