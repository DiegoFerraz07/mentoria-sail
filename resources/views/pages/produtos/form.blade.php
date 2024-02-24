@extends('layouts.app', ['activePage' => 'dashboard', 'title' => 'Light Bootstrap Dashboard Laravel by Creative Tim & UPDIVISION', 'navName' => 'Dashboard', 'activeButton' => 'laravel'])

@section('content')
    <form>
        @csrf
        <input type="hidden"
            id="product-id"
            value="{{ isset($produdo) ? $produto->id : ''}}">
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text"
                class="form-control"
                name="nome"
                id="nome"
                value="{{ isset($produto) ? $produto->nome : ''}}"
                required
                placeholder="Nome">
        </div>
        <div class="form-group">
            <label for="valor">Valor</label>
            <input type="text"
                class="form-control valor"
                name="valor"
                id="valor"
                value="{{ isset($produto) ? $produto->valor : ''}}"
                required
                placeholder="Valor">
            <div id="valor-error" class="error"></div>
        </div>
        <button type="submit" class="btn btn-success mt-2">Salvar</button>
    </form>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script type="text/javascript">

            $("form").submit(function(e) {
                e.preventDefault();

                const formInputs = $(this)[0].getElementsByTagName('input');
                let formData = {};
                for (let input of formInputs) {
                    formData[input.nome] = input.value;
                }

                let route = "{{route('product.store')}}";
                let messageSuccess = "Adicionado com sucesso";
                const productId = $('#product-id').val();
                if(productId) {
                    route = "{{route('product.update')}}";
                    messageSuccess = "Alterado com sucesso";
                    formData['id'] = productId;
                }

                axios.post(
                    route,
                    formData
                ).then(response => {
                    let apiResponse = response.data;
                    if(apiResponse.data != undefined) {
                        apiResponse = apiResponse.data;
                    }
                    if(apiResponse.success) {
                        alertSweet(
                            messageSuccess,
                            'success',
                            success => {
                                document.location.href = "{{ route('product.index')}}";
                            }
                        );
                    } else {
                        let message = 'Não foi possivel Salvar!!';
                        if(apiResponse.message) {
                            message = apiResponse.message;
                        }
                        alertSweet(
                            message,
                            'error'
                        )
                    }

                })
                .catch(error => {
                    console.log(error)
                    alertSweet(
                        'Não foi possivel Salvar!!',
                        'error'
                    )
                });
            });
        });
    </script>
@endsection

