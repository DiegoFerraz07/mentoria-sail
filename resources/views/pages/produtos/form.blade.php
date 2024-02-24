@extends('layouts.app', ['activePage' => 'dashboard', 'title' => 'Light Bootstrap Dashboard Laravel by Creative Tim & UPDIVISION', 'navName' => 'Dashboard', 'activeButton' => 'laravel'])

@section('content')

    <form>
        @csrf
        <input type="hidden"
            id="product-id"
            value="{{ isset($product) ? $product->id : ''}}">
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text"
                class="form-control"
                name="nome"
                id="nome"
                value="{{ isset($product) ? $product->nome : ''}}"
                required
                placeholder="Nome">
        </div>
        <div class="form-group">
            <label for="valor">Valor</label>
            <input type="text"
                class="form-control valor"
                name="valor"
                id="valor"
                value="{{ isset($product) ? $product->valor : ''}}"
                required
                placeholder="Valor">
            <div id="valor-error" class="error"></div>
        </div>
        <div class="form-group">
            <!-- TODO: fazer o editar tbm -->
            <label for="valor">Tipos</label>            
            <select id="types" name="types[]" multiple="multiple" class="form-control">
                @empty ($types)
                    <option value="">Nenhum tipo cadastrado</option>
                @else
                    <option value="" readonly disabled >Selecione um tipo</option>
                @endempty

                @foreach ($types as $type)
                    <option value="{{$type->id}}">{{$type->name}}</option>
                @endforeach

            </select>
            <div id="valor-error" class="error"></div>
        </div>
        <button type="submit" class="btn btn-success mt-2">Salvar</button>
    </form>
@endsection

@section('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js" integrity="sha512-efAcjYoYT0sXxQRtxGY37CKYmqsFVOIwMApaEbrxJr4RwqVVGw8o+Lfh/+59TU07+suZn1BWq4fDl5fdgyCNkw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#types').select2();

            $("#valor").inputmask('decimal', {
                'alias': 'numeric',
                'groupSeparator': '.',
                'autoGroup': false,
                'digits': 2,
                'radixPoint': ",",
                'digitsOptional': false,
                'unmaskAsNumber': true,
                'allowMinus': false,
                'prefix': 'R$ ',
                'placeholder': '',
                'rightAlign': false,
            });


            $("form").submit(function(e) {
                e.preventDefault();

                // remover mascara do valor R$ ou US$

                const formInputs = $(this)[0].getElementsByTagName('input');
                let formData = {};
                for (let input of formInputs) {
                    formData[input.name] = input.value;
                }
                $types = $('#types').val();
                if($types) {
                    formData['types'] = $types;
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
                    return apiResponse;
                })                
                .then(response => {
                    if(response.success) {
                        alertSweet(
                            messageSuccess,
                            'success',
                            success => {
                                document.location.href = "{{ route('product.index')}}";
                            }
                        );
                    } else {
                        let message = 'Não foi possivel Salvar!!';
                        if(response.message) {
                            message = response.message;
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

