{{-- Extends da index --}}
@extends('index')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Fornecedores</h1>
    </div>
    <div>
        <form action="{{ route('supply.find') }}" method="POST">
            @csrf
            <input type="text" required minlength="3" value="{{$search ?? ''}}" name="search" placeholder="Digite o nome" />
            <button> pesquisar </button>
            @if(isset($search))
                <a href="{{ route('supply.index') }}" class="btn btn-danger btn-sm">
                    Limpar Pesquisa
                </a>
            @endif
        </form>
        <a type="button" href="{{route('supply.add')}}" class="btn btn-success float-end">
            Adicionar
        </a>
        <div class="table-responsive mt-4">
            @if ($supplies->isEmpty())
                <p> Não existe dados </p>
            @else
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>cnpj</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($supplies as $supply)
                            <tr>
                                <td>{{ $supply->id }}</td>
                                <td>{{ $supply->name }}</td>
                                <td>{{ $supply->cnpj }}</td>
                                <td>
                                    <a href="#" class="btn btn-light btn-sm">
                                        Editar
                                    </a>

                                    <meta name='csrf-token' content="{{ csrf_token() }}"/>
                                    <button onclick="deleteSupply('{{$supply->id}}', '{{$supply->name}}')" class="btn btn-danger btn-sm">
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
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    function deleteSupply(id, name) {
        Swal.fire({
            title: 'Atenção',
            html: `Deseja realmente excluir o fornecedor <b>"${name}"</b>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#868e96',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, remover!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.delete('{{route("supply.delete")}}', {
                    data: {
                        idForne: id,
                    }
                })
                .then(response => {

                    if(response.data.success) {
                        Swal.fire({
                            title: 'Excluido com sucesso',
                            icon: 'success'
                        })
                        .then(res => {
                            document.location.reload();
                        })
                    }
                })
                .catch(error => {
                    Swal.fire(
                        'Oops',
                        'Não foi possivel excluir!!',
                        'error'
                    )
                    
                });
            }
        });
    }
</script>
@endsection