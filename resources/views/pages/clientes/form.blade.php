@extends('layouts.app', ['activePage' => 'dashboard', 'title' => 'Light Bootstrap Dashboard Laravel by Creative Tim & UPDIVISION', 'navName' => 'Dashboard', 'activeButton' => 'laravel'])

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
            <label for="name">E-mail</label>
            <input type="text"
                class="form-control"
                name="email"
                id="email"
                value="{{ isset($client) ? $client->email : ''}}"
                required
                placeholder="E-mail">
        </div>
        <div class="form-group">
            <label for="cpf">CPF/CNPJ</label>
            <input type="hidden" 
                id="isLegalAge" 
                name="is_legal_age" 
                value="{{ isset($client) && isset($client->is_legal_age) ? $client->is_legal_age : '0'}}">
            <input type="text"
                class="form-control document"
                name="document"
                id="document"
                @if (isset($client) && $client->cpf != "" && $client->cpf != null && strlen($client->cpf) == 14)
                    value="{{ $client->cpf }}"
                @elseif((isset($client) && $client->cnpj != "" && $client->cnpj != null && strlen($client->cnpj) == 18))
                    value="{{ $client->cnpj }}"
                @else
                    value=""
                @endif
                required
                placeholder="CPF/CNPJ">
            <div id="document-error" class="error"></div>
        </div>
        <div class="form-group">
            <label for="date">Data Nascimento</label>
            <input type="text"
                class="form-control date"
                name="date"
                id="date"
                value="{{ isset($client) ? $client->date_formatted : ''}}"
                required
                readonly
                placeholder="Data de Nascimento">
            <div id="data-error" class="error"></div>
        </div>

        <button type="submit" class="btn btn-success mt-2">Salvar</button>
    </form>
@endsection

@section('scripts')
    <script src="{{ Vite::asset('resources/js/utils/cpf-verify.js') }}"></script>
    <script src="{{ Vite::asset('resources/js/utils/cnpj-verify.js') }}"></script>
    <script src="{{ Vite::asset('resources/js/utils/utils.js') }}"></script>
    <script src="{{ Vite::asset('resources/js/utils/handle-axios.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script type="text/javascript">
    // executa tudo que ta aqui dentro quando a página for totalmente carregada
        $(document).ready( function() {

            function setMessageErrorCPF(message = '') {
                $('#document-error')[0].innerHTML = message;
            }

            function validateIsLegalAge() {
                const isLegalAge = $('#isLegalAge').val();
                if(isLegalAge == 1) {
                    return true;
                }
                return false;
            }

            function validateDocument() {
                // pegar o valor do input cpf
                const document = $('#document').val();
                // Limpar a div
                setMessageErrorCPF();
                // verifica o tamanho do cpf
                if(document.length == 14) {
                    if(!scriptValidityCPF(document)) {
                        setMessageErrorCPF("<p class='text-danger'>CPF inválido</p>");
                        return false;
                    } else {
                        setMessageErrorCPF("<p class='text-success'>CPF válido</p>")
                        return true;
                    }
                } else if(document.length == 18) {
                    if(!scriptValidityCNPJ(document)) {
                        setMessageErrorCPF("<p class='text-danger'>CNPJ inválido</p>");
                        return false;
                    } else {
                        setMessageErrorCPF("<p class='text-success'>CNPJ válido</p>")
                        return true;
                    }
                }
                return false
            }
            $('#document').keyup(function (event) {
                validateDocument();
            });

            var options = {
                onKeyPress: function (doc, ev, el, op) {
                    var masks = ['000.000.000-00#', '00.000.000/0000-00'];
                    var mask = doc.length <= 14 ? masks[0] : masks[1]
                    $('#document').mask(mask, op);
                }
            }
            
            $('#document').mask('000.000.000-00#', options);
            $('#document').trigger('input');
            validateDocument();


            $('input[name="date"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 1901,
                maxDate: moment(),
                locale: localePtBR()
            }, function(start, end, label) {
                var years = moment().diff(start, 'years');
                if(years >= 18) {
                    $('#isLegalAge').val(1);
                } else {
                    $('#isLegalAge').val(0);
                }
            });

            function isCPF() {
                return $('#document').val().length == 14;
            }

            $("form").submit(async function(e) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();

                let isCNPJ = false;

                if(!validateDocument()) {
                    const typeDoc = isCPF() ? 'CPF' : 'CNPJ';
                    alertSweet(
                            `informe um ${typeDoc} válido!`,
                            'error'
                        )
                    return;
                }

                if(!isCPF()) {
                    $('#isLegalAge').val(1);
                    isCNPJ = true;
                }

                if(!validateIsLegalAge() && isCPF()) {
                    alertSweet(
                            'Você não possui idade minima para se cadastrar!',
                            'error'
                        )
                    return;
                }

                const formInputs = $(this)[0].getElementsByTagName('input');
                let formData = {};
                for (let input of formInputs) {
                    formData[input.name] = input.value;
                }

                formData['isCNPJ'] = isCNPJ;

                let route = "{{route('client.store')}}";
                let messageSuccess = "Adicionado com sucesso";
                const clientId = $('#client-id').val();
                
                if(clientId) {
                    route = "{{route('client.update')}}";
                    messageSuccess = "Alterado com sucesso";
                    formData['id'] = clientId;
                }
                return await handleAxios({
                    url: route,
                    data: formData,
                    method: clientId ? 'put' : 'post',
                    successCallback: successCallback = () => {
                        alertSweet(
                            '',
                            'success',
                            success => {
                                document.location.href = "{{ route('client.index')}}";
                            }
                        );
                        return true;
                    },
                    errorCallback: errorCallback = (message) => {
                        alertSweet(
                            message,
                            'error'
                        );
                        return false;
                    },
                });
            });
        });
    </script>
@endsection