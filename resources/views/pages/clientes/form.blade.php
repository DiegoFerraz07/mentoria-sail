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
            <label for="cpf">CPF</label>
            <input type="text"
                class="form-control cpf"
                name="cpf"
                maxlength="14"
                minlength="14"
                id="cpf"
                mask="000.000.000-00"
                value="{{ isset($client) ? $client->cpf : ''}}"
                required
                placeholder="CPF">
            <div id="cpf-error" class="error"></div>
        </div>
        <div class="form-group">
            <label for="date">Data Nascimento</label>
            <input type="text"
                class="form-control date"
                name="date"
                id="date"
                value="{{ isset($client) ? $client->date : ''}}"
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script type="text/javascript">
    // executa tudo que ta aqui dentro quando a página for totalmente carregada
        $(document).ready( function() {

            function setMessageErrorCPF(message = '') {
                $('#cpf-error')[0].innerHTML = message;
            }

            function validateCPF() {
                // pegar o valor do input cpf
                const cpf = $('#cpf').val();
                // Limpar a div
                setMessageErrorCPF();
                // verifica o tamanho do cpf
                if(cpf.length == 14) {
                    if(!validity(cpf)) {
                        setMessageErrorCPF("<p class='text-danger'>CPF inválido</p>");
                        return false;
                    } else {
                        setMessageErrorCPF("<p class='text-success'>CPF válido</p>")
                        return true;
                    }
                }
                return false
            }
            $('#cpf').keyup(function (event) {
                validateCPF();
            });
            $('#cpf').mask('000.000.000-00', {reverse: false});
            $('input[name="date"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 1901,
                maxDate: moment(),
                locale: {
                    format: 'DD/MM/YYYY',
                    applyLabel: 'Aplicar',
                    cancelLabel:  'Cancelar',
                    weekLabel: 'S',
                    daysOfWeek: [
                        "D",
                        "S",
                        "T",
                        "Q",
                        "Q",
                        "S",
                        "S"
                    ],
                    monthNames: [
                        "Janeiro",
                        "Fevereiro",
                        "Março",
                        "Abril",
                        "Maio",
                        "Junho",
                        "Julho",
                        "Agosto",
                        "Setembro",
                        "Outubro",
                        "Novembro",
                        "Dezembro"
                    ],
                }
            }, function(start, end, label) {
                console.log(start.format('YYYY-MM-DD'));
            });
            $("form").submit(function(e) {
                e.preventDefault();

                if(!validateCPF()) {
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
                const clientId = $('#client-id').val();
                if(clientId) {
                    route = "{{route('supply.update')}}";
                    messageSuccess = "Alterado com sucesso";
                    formData['id'] = clientId;
                }

                axios.post(
                    route,
                    formData
                ).then(response => {
                    console.log(response);
                    const apiResponse = response.data;
                    if(apiResponse.data.success) {
                        alertSweet(
                            messageSuccess,
                            'success',
                            success => {
                                document.location.href = "{{ route('client.index')}}";
                            }
                        );
                    } else {
                        let message = 'Não foi possivel Salvar!!';
                        if(apiResponse.data.message) {
                            message = apiResponse.data.message;
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

