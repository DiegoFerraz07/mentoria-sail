{{-- Extends da index --}}
@extends('layouts.app', ['activePage' => 'types', 'title' => 'Types', 'navName' => 'Store', 'activeButton' => 'types'])

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Types</h1>
    </div>
    <div>
        <form action="{{ route('types.find') }}" method="POST">
            @csrf
            <input type="text" required minlength="3" value="{{$search ?? ''}}" name="search" placeholder="Digite o nome" />
            <button> pesquisar </button>
            @if(isset($search))
                <a href="{{ route('types.index') }}" class="btn btn-danger btn-sm">
                    Limpar Pesquisa
                </a>
            @endif
        </form>
        <a type="button" href="{{route('types.add')}}" class="btn btn-success float-end">
            Adicionar
        </a>
        <div class="table-responsive mt-4">
            @if ($types->isEmpty())
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
                        @foreach ($types as $type)
                            <tr>
                                <td>{{ $type->id }}</td>
                                <td>{{ $type->name }}</td>
                                <td>{{ $type->description }}</td>
                                <td>@datetime_ptbr($type->created_at)</td>
                                <td>@datetime_ptbr($type->updated_at)</td>
                                <td>
                                    <a href="{{route("types.edit", ['id' => $type->id])}}" class="btn btn-light btn-sm">
                                        Editar
                                    </a>

                                    <meta name='csrf-token' content="{{ csrf_token() }}"/>
                                    <button onclick="confirmDeleteClient('{{$type->id}}', '{{$type->name}}')" class="btn btn-danger btn-sm">
                                        Excluir
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $types->links() }}
            @endif
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function confirmDeleteClient(id, name) {
        const alertSwal = window.alertSweet;
        alertSwal(
            `Deseja realmente excluir o tipo <b>"${name}"</b>?`,
            'warning',
            success => {
                this.deleteClient(id);
            }
        );
    }

    function deleteClient(id) {
       axios.delete('{{route("types.delete")}}', {
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
