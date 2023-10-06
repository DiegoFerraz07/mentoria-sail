{{-- Extends da index --}}
@extends('index')

@section('content')
    <form>
        @csrf
        <input type="hidden"
            id="client-id"
            value="{{ isset($client) ? $client->id : ''}}">
        <div class="form-group">
            <label for="name">Nome</label>
            <input type="text"
                class="form-control"
                name="name"
                id="name"
                value="{{ isset($client) ? $client->name : ''}}"
                required
                placeholder="Nome">
        </div>
        <div class="form-group">
            <label for="cpf">CPF</label>
            <input type="text"
                class="form-control cnpj"
                name="cnpj"
                maxlength="14"
                minlength="14"
                id="cpf"
                mask="000.000.000-00"
                value="{{ isset($client) ? $client->cpf : ''}}"
                required
                placeholder="CPF">
            <div id="cpf-error" class="error"></div>
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
                $('#cpf-error')[0].innerHTML = message;
            }

            function validityCPF() {
                // pega o valor do input do cpf
                const cpf = $('#cpf').val();
                //limpa a mensagem de erro da div
                setMessageErrorCPF();
                // verificando o tamho do cnpj antes de mostra a mensagem
                if(cpf.length == 14) {
                    if(!validity(cnpj)) {
                        setMessageErrorCPF("<p class='text-danger'>CPF inválido</p>");
                        return false;
                    } else {
                        setMessageErrorCPF("<p class='text-success'>CPF válido</p>")
                        return true;
                    }
                }
                return false;
            }

            $('#cpf').keyup(function (event) {
                validityCNPJ();
            });

            $('#cpf').mask('000.000.000-00', {reverse: false});
            $("form").submit(function(e) {
                e.preventDefault();

                if(!validityCPF()) {
                    alertSweet(
                            'informe um CPF válido!',
                            'error'
                        )
                    return;
                }

                const formInputs = $(this)[0].getElementsByTagName('input');
                let formData = {};
                for (let input of formInputs) {
                    formData[input.name] = input.value;
                }

                /*Rota a criar ainda...*/
                let route = "{{route('client.store')}}";
                let messageSuccess = "Adicionado com sucesso";
                const supplyId = $('#supply-id').val();
                if(supplyId) {
                    route = "{{route('supply.update')}}";
                    messageSuccess = "Alterado com sucesso";
                    formData['id'] = supplyId;
                }

                axios.post(
                    route,
                    formData
                ).then(response => {
                    if(response.data.success) {
                        alertSweet(
                            messageSuccess,
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

