{{-- Extends da index --}}
@extends('layouts.app', ['activePage' => 'brand', 'title' => 'Marcas', 'navName' => 'Store', 'activeButton' => 'brand'])

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Marcas</h1>
    </div>
    <div>
        <form action="{{ route('brand.find') }}" method="POST">
            @csrf
            <input type="text" required minlength="3" value="{{$search ?? ''}}" name="search" placeholder="Digite o nome" />
            <button> pesquisar </button>
            @if(isset($search))
                <a href="{{ route('brand.index') }}" class="btn btn-danger btn-sm">
                    Limpar Pesquisa
                </a>
            @endif
        </form>
        <a type="button" href="{{route('brand.add')}}" class="btn btn-success float-end">
            Adicionar
        </a>
        <div class="table-responsive mt-4">
            @if ($brand->isEmpty())
                <p> Não existe dados </p>
            @else
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Data de Criação</th>
                            <th>Data de Edição</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($brand as $brand)
                            <tr>
                                <td>{{ $brand->id }}</td>
                                <td>{{ $brand->name }}</td>
                                <td>{{ $brand->description }}</td>
                                <td>@datetime_ptbr($brand->created_at)</td>
                                <td>@datetime_ptbr($brand->updated_at)</td>
                                <td>
                                    <a href="{{route("brand.edit", ['id' => $brand->id])}}" class="btn btn-light btn-sm">
                                        Editar
                                    </a>

                                    <meta name='csrf-token' content="{{ csrf_token() }}"/>
                                    <button onclick="confirmDeleteBrand('{{$brand->id}}', '{{$brand->name}}')" class="btn btn-danger btn-sm">
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
    function confirmDeleteBrand(id, name) {
        const alertSwal = window.alertSweet;
        alertSwal(
            `Deseja realmente excluir o tipo <b>"${name}"</b>?`,
            'warning',
            success => {
                this.deleteBrand(id);
            }
        );
    }

    function deleteBrand(id) {
       axios.delete('{{route("brand.delete")}}', {
            data: {
                id,
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
