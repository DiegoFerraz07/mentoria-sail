@extends('layouts.app', ['activePage' => 'brand', 'title' => 'Add Brand', 'navName' => 'brand', 'activeButton' => 'brand'])

@section('content')
    <form>
        @csrf
        <input type="hidden"
            id="brand-id"
            value="{{ isset($brand) ? $brand->id : ''}}">
        <div class="form-group">
            <label for="name">Nome</label>
            <input type="text"
                class="form-control"
                name="name"
                id="name"
                value="{{ isset($brand) ? $brand->name : ''}}"
                required
                placeholder="Nome">
        </div>
        <div class="form-group">
            <label for="description">Descrição</label>
            <input type="text"
                class="form-control"
                name="description"
                maxlength="512"
                minlength="3"
                value="{{ isset($brand) ? $brand->description : ''}}"
                required
                placeholder="Descrição">
        </div>
        <button type="submit" class="btn btn-success mt-2">Salvar</button>
    </form>
@endsection

@section('scripts')
    <script src="{{ Vite::asset('resources/js/utils/utils.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script type="text/javascript">
    // executa tudo que ta aqui dentro quando a página for totalmente carregada
        $(document).ready( function() {

            $("form").submit(function(e) {
                e.preventDefault();
                const formInputs = $(this)[0].getElementsByTagName('input');
                let formData = {};
                for (let input of formInputs) {
                    formData[input.name] = input.value;
                }
                /*Rota a criar ainda...*/
                let route = "{{route('brand.store')}}";
                let messageSuccess = "Adicionado com sucesso";
                const brandId = $('#brand-id').val();
                if(brandId) {
                    route = "{{route('brand.update')}}";
                    messageSuccess = "Alterado com sucesso";
                    formData['id'] = brandId;
                }

                axios.post(
                    route,
                    formData
                ).then(response => {
                    let apiResponse = response.data;
                    if(apiResponse.data) {
                        apiResponse = apiResponse.data;
                    }
                    if(apiResponse.success) {
                        alertSweet(
                            messageSuccess,
                            'success',
                            success => {
                                document.location.href = "{{ route('brand.index')}}";
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
                    alertSweet(
                        'Não foi possivel Salvar!!',
                        'error'
                    )
                });
            });
        });
    </script>
@endsection

