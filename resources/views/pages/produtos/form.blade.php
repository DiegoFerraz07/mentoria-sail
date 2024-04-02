@extends('layouts.app', ['activePage' => 'dashboard', 'title' => 'Light Bootstrap Dashboard Laravel by Creative Tim & UPDIVISION', 'navName' => 'Dashboard', 'activeButton' => 'laravel'])

@section('content')
    <form>
        @csrf
        <input type="hidden" id="product-id" value="{{ isset($product) ? $product->id : '' }}">
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" name="nome" id="nome"
                value="{{ isset($product) ? $product->nome : '' }}" required placeholder="Nome">
        </div>
        <div class="form-group">
            <label for="valor">Valor</label>
            <input type="text" class="form-control valor" name="valor" id="valor"
                value="{{ isset($product) ? $product->valor : '' }}" required placeholder="Valor">
            <div id="valor-error" class="error"></div>
        </div>
        <div class="form-group">
            <label for="valor">Tipos</label>
            <select id="types" name="types[]" multiple="multiple" class="form-control" >
                @empty($types)
                    <option value="">Nenhum tipo cadastrado</option>
                @else
                    <option value="" readonly disabled >Selecione um tipo</option>
                @endempty

                @foreach ($types as $type)
                    @if($productTypes && in_array($type->id, $productTypes))
                        <option value="{{ $type->id }}" selected>{{ $type->name }}</option>
                    @else
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endif
                @endforeach
            </select>
            <div id="valor-error" class="error"></div>
        </div>
        <div class="form-group">
            <label for="valor">Marcas</label>
            <select id="brandId" name="brandId"  class="form-control" >
                @empty($brands)
                    <option value="">Nenhuma marca cadastrada</option>
                @else
                    <option value="" readonly disabled selected>Selecione uma marca</option>
                @endempty

                @foreach ($brands as $brand)
                    @if(isset($product->brand_id) && $brand->id == $product->brand_id)
                        <option value="{{ $brand->id }}" selected>{{ $brand->name }}</option>
                    @else
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endif
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"
        integrity="sha512-efAcjYoYT0sXxQRtxGY37CKYmqsFVOIwMApaEbrxJr4RwqVVGw8o+Lfh/+59TU07+suZn1BWq4fDl5fdgyCNkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="{{ Vite::asset('resources/js/utils/handle-axios.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#types').select2({
                placeholder:'Selecione um tipo'
            });
            $('#types').on("select2:unselecting", async function(e){
                e.preventDefault();
                await alertSweet(
                    'Deseja realmente remover o tipo?',
                    'warning',
                    success => {
                        if (success) {
                            $(e.params.args.data.element).remove();
                            $(e.target).trigger('change');
                        }
                        return true;
                    },
                    cancel => {
                        return false;
                    }
                );
            });

            $('#brands').select2();
            $('#brands').on("select2:unselecting", async function(e){
                e.preventDefault();
                await alertSweet(
                    'Deseja realmente remover a Marca?',
                    'warning',
                    success => {
                        if (success) {
                            $(e.params.args.data.element).remove();
                            $(e.target).trigger('change');
                        }
                        return true;
                    },
                    cancel => {
                        return false;
                    }
                );
            });

            
            var MoneyOptsMinus = {
                reverse: true,
                maxlength: false,
                placeholder: '0,00',
                byPassKeys: [9, 16, 17, 18, 35, 36, 37, 38, 39, 40, 46, 91],
                eventNeedChanged: false,
                onKeyPress: function(v, ev, curField, opts) {
                    var mask = curField.data('mask').mask;
                    var decimalSep = (/0(.)00/gi).exec(mask)[1] || ',';

                    opts.prefixMoney = typeof(opts.prefixMoney) != 'undefined' ? opts.prefixMoney : '';

                    if (curField.data('mask-isZero') && curField.data('mask-keycode') == 8)
                        $(curField).val('');
                    else if (v) {
                        var key = curField.data('mask-key');
                        var minus = (typeof(curField.data('mask-minus-signal')) == 'undefined' ? false :
                            curField.data('mask-minus-signal'));

                        if (['-', '+'].indexOf(key) >= 0) {
                            curField.val((opts.prefixMoney) + (key == '-' ? key + v : v.replace(/^-?/,
                            '')));
                            curField.data('mask-minus-signal', key == '-');
                            return;
                        }

                        // remove previously added stuff at start of string
                        v = v.replace(new RegExp('^-?'), '');
                        v = v.replace(new RegExp('^0*\\' + decimalSep + '?0*'),
                        ''); //v = v.replace(/^0*,?0*/, '');
                        v = v.length == 0 ? '0' + decimalSep + '00' : (v.length == 1 ? '0' + decimalSep +
                            '0' + v : (v.length == 2 ? '0' + decimalSep + v : v));
                        curField.val((opts.prefixMoney) + (minus ? '-' : '') + v).data('mask-isZero', (v ==
                            '0' + decimalSep + '00'));
                    }
                }
            };

            var MoneyOptsPrefix = {};
            MoneyOptsPrefix = $.extend(true, {}, MoneyOptsPrefix, MoneyOptsMinus);
            MoneyOptsPrefix.prefixMoney = 'R$ ';

            $('#valor').mask("000.000.000.000.000,00", MoneyOptsPrefix).keydown().keyup();
            // simula uma ação de adicionar 
            $('#valor').trigger('input');

            $("form").submit(async function(e) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();

                // remover mascara do valor R$ ou US$

                const formInputs = $(this)[0].getElementsByTagName('input');
                let formData = {};
                for (let input of formInputs) {
                    formData[input.name] = input.value;
                }
                $types = $('#types').val();
                if ($types) {
                    formData['types'] = $types;
                }

                $brandId = $('#brandId').val();
                if ($brandId) {
                    formData['brandId'] = $brandId;
                }

                let route = "{{ route('product.store') }}";
                let messageSuccess = "Adicionado com sucesso";
                const productId = $('#product-id').val();
                if (productId) {
                    route = "{{ route('product.update') }}";
                    messageSuccess = "Alterado com sucesso";
                    formData['id'] = productId;
                }

                return await handleAxios({
                    url: route,
                    data: formData,
                    method: productId ? 'put' : 'post',
                    successCallback: successCallback = () => {
                        alertSweet(
                            '',
                            'success',
                            success => {
                                document.location.href = "{{ route('product.index') }}"
                            }
                        );
                        return true;
                    },
                    errorCallback: errorCallback = () => {
                        alertSweet(
                            'Erro ao salvar',
                            'error'
                        );
                        return false;
                    },
                });
            });
        });
    </script>
@endsection
