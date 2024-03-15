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
            @if ($brands->isEmpty())
                <p> Não existe dados </p>
            @else
            <div id="app">
                <brand
                    brands="{{json_encode($brands)}}" />
            </div>
                {{ $brands->links() }}
            @endif
        </div>
    </div>
@endsection

@vite('resources/js/app.js')
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
