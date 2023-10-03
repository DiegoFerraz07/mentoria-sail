{{-- Extends da index --}}
@extends('index')

@section('content')
    <form>
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
            <div id="cnpj-error" class="error"></div>
        </div>
        <button type="submit" class="btn btn-success mt-2">Salvar</button>
    </form>
@endsection

@section('scripts')
    <script src="{{ Vite::asset('resources/js/utils/cnpj-verify.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script type="text/javascript">
    // executa tudo que ta aqui dentro quando a página for totalmente carregada
        $(document).ready( function() {
            function setMessageErrorCNPJ(message = '') {
                $('#cnpj-error')[0].innerHTML = message;
            }
            
            function validityCNPJ() {
                // pega o valor do input do cnpj 
                const cnpj = $('#cnpj').val();
                //limpa a mensagem de erro da div
                setMessageErrorCNPJ();
                // verificando o tamho do cnpj antes de mostra a mensagem
                if(cnpj.length == 18) {
                    if(!validity(cnpj)) {
                        setMessageErrorCNPJ("<p class='text-danger'>CNPJ inválido</p>");
                        return false;
                    } else {
                        setMessageErrorCNPJ("<p class='text-success'>CNPJ válido</p>")
                        return true;
                    }
                }
                return false;
            }
            
            $('#cnpj').keyup(function (event) {
                validityCNPJ();
            });
            
            $('#cnpj').mask('00.000.000/0000-00', {reverse: false});
            $("form").submit(function(e) {
                e.preventDefault();
                
                if(!validityCNPJ()) {
                    alertSweet(
                            'informe um CNPJ válido!',
                            'error'
                        )
                    return;
                }

                const formInputs = $(this)[0].getElementsByTagName('input');
                let formData = {};
                for (let input of formInputs) {
                    formData[input.name] = input.value;
                }

                axios.post(
                    "{{route('supply.store')}}", 
                    formData
                ).then(response => {
                    if(response.data.success) {
                        alertSweet(
                            'Adicionado com sucesso', 
                            'success',
                            success => {
                                document.location.href = "{{ route('supply.index')}}";
                            }
                        );
                    } else {
                        let message = 'Não foi possivel excluir!!';
                        if(response.data.message) {
                            message = response.data.message;
                        }
                        alertSweet(
                            message,
                            'error'
                        )
                    }

                })
                .catch(error => {
                    alertSweet(
                        'Não foi possivel excluir!!',
                        'error'
                    )
                });
            });
        });
    </script>
@endsection

