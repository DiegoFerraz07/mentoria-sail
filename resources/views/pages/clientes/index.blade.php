{{-- Extends da index --}}
@extends('layouts.app', ['activePage' => 'dashboard', 'title' => 'Light Bootstrap Dashboard Laravel by Creative Tim & UPDIVISION', 'navName' => 'Dashboard', 'activeButton' => 'laravel'])

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Client</h1>
    </div>
    <div>
        <form action="{{ route('client.find') }}" method="POST">
            @csrf
            <input type="text" required minlength="1" value="{{$search ?? ''}}" name="search" placeholder="Digite o nome" />
            <button> pesquisar </button>
            @if(isset($search))
                <a href="{{ route('client.index') }}" class="btn btn-danger btn-sm">
                    Limpar Pesquisa
                </a>
            @endif
        </form>
        <a type="button" href="{{route('client.add')}}" class="btn btn-success float-end">
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
                            <th>Email</th>
                            <th>CPF/CNPJ</th>
                            <th>Data</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $client)
                            <tr>
                                <td>{{ $client->id }}</td>
                                <td>{{ $client->name }}</td>
                                <td>{{ $client->email }}</td>
                                @if($client->cpf)
                                    <td>{{ $client->cpf }}</td>
                                @else
                                    <td>{{ $client->cnpj }}</td>
                                @endif
                                <!--td>{{ $client->date_formatted }}</td-->
                                <td>@date_ptbr($client->date)</td>
                                <td>
                                    <a href="{{route("client.edit", ['id' => $client->id])}}" class="btn btn-light btn-sm">
                                        Editar
                                    </a>

                                    <meta name='csrf-token' content="{{ csrf_token() }}"/>
                                    <button onclick="confirmDeleteClient('{{$client->id}}', '{{$client->name}}')" class="btn btn-danger btn-sm">
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
    function confirmDeleteClient(id, name) {
        const alertSwal = window.alertSweet;
        alertSwal(
            `Deseja realmente excluir o Cliente <b>"${name}"</b>?`,
            'warning',
            success => {
                this.deleteClient(id);
            }
        );
    }

    function deleteClient(id) {
        axios.delete('{{route("client.delete")}}', {
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
