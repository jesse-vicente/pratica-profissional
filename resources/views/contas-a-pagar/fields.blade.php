@isset($contaPagar)
    <input type="hidden" name="senha" id="senha">
@endisset

<div class="form-row">
    <div class="form-group required col-xl-2">
        <label>Modelo</label>
        <input
            type="number"
            id="modelo"
            name="modelo"
            max="99"
            oninput="validity.valid || (value = '');"
            class="form-control @error('modelo') is-invalid @enderror"
            @isset($compra)
                value="{{ old('modelo', $compra->getModelo()) }}"
            @else
                value="{{ old('modelo', isset($contaPagar) ? $contaPagar->getModelo() : 55) }}"
            @endisset
            required
        >

        <span class="invalid-feedback" role="alert" ref="modelo"></span>
    </div>

    <div class="form-group required col-xl-2">
        <label>Série</label>
        <input
            type="text"
            id="serie"
            name="serie"
            max="999"
            oninput="validity.valid || (value = '');"
            class="form-control @error('serie') is-invalid @enderror"
            @isset($compra)
                value="{{ old('serie', $compra->getSerie()) }}"
            @else
                value="{{ old('serie', isset($contaPagar) ? $contaPagar->getSerie() : 1) }}"
            @endisset
            required
        >

    </div>

    <div class="form-group required col-xl-2">
        <label>Número</label>
        <input
            type="number"
            id="num_nota"
            name="num_nota"
            min="1"
            max="999999"
            step="1"
            oninput="validity.valid || (value = '');"
            class="form-control @error('num_nota') is-invalid @enderror"
            @isset($compra)
                value="{{ old('num_nota', $compra->getNumeroNota()) }}"
            @else
                value="{{ old('num_nota', isset($contaPagar) ? $contaPagar->getNumeroNota() : null) }}"
            @endisset
            required
        >

    </div>

    <div class="form-group required col-xl-3">
        <label>Data de Emissão</label>
        <input
            type="date"
            id="data_emissao"
            name="data_emissao"
            class="form-control @error('data_emissao') is-invalid @enderror"

            @isset($compra)
                value="{{ old('data_emissao', $compra->getDataEmissao()) }}"
            @elseif (isset($contaPagar))
                value="{{ old('data_emissao', $contaPagar->getDataEmissao()) }}"
            @else
                value="{{ old('data_emissao', date('Y-m-d')) }}"
                min="{{ date('Y-m-d') }}"
                max="{{ date('Y-m-d') }}"
            @endisset

            readonly
            required
        >

        @error('data_emissao')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

</div>

<div class="form-row">
    <div class="form-group required col-xl-2">
        <label>Código</label>
        <input
            type="number"
            class="form-control @error('fornecedor_id') is-invalid @enderror"
            name="fornecedor_id"
            id="fornecedor_id"
            data-input="#fornecedor"
            data-route="fornecedores"
            value="{{ old('fornecedor_id', isset($contaPagar) ? $contaPagar->getFornecedor()->getId() : null) }}"
            min="1"
            step="1"
            oninput="validity.valid || (value = '');"
            required
        >

        @error('fornecedor_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group required col-xl-9">
        <label>Fornecedor</label>
        <div class="input-group">
            <input
                class="form-control"
                name="fornecedor"
                id="fornecedor"
                value="{{ old('fornecedor', isset($contaPagar) ? $contaPagar->getFornecedor()->getRazaoSocial() : null) }}"
                readonly
            >

            <div class="input-group-append">
                <button
                    class="btn btn-primary btn-search"
                    type="button"
                    data-input="#fornecedor_id"
                    data-route="fornecedores"
                    data-toggle="modal"
                    data-target="#modal-fornecedores"
                >
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>

        <span class="invalid-feedback" role="alert" ref="fornecedor"></span>
    </div>

    <div id="modal-fornecedores" class="modal fade" data-field="fornecedor" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header align-items-center py-2 bg-dark">
                    <h3 class="modal-title">Buscar Fornecedor</h3>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    @include('fornecedores.search')
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-row mt-4">
    <div class="form-group required col-xl-2">
        <label>Código</label>
        <input
            type="number"
            class="form-control @error('forma_pagamento_id') is-invalid @enderror"
            name="forma_pagamento_id"
            id="forma_pagamento_id"
            data-input="#forma_pagamento"
            data-route="formas-pagamento"
            value="{{ old('forma_pagamento_id', isset($contaPagar) ? $contaPagar->getFormaPagamento()->getId() : null) }}"
            required
        >

        @error('forma_pagamento_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group required col-xl-9">
        <label>Forma de Pagamento</label>
        <div class="input-group">
            <input
                type="text"
                class="form-control"
                name="forma_pagamento"
                id="forma_pagamento"
                value="{{ old('forma_pagamento', isset($contaPagar) ? $contaPagar->getFormaPagamento()->getFormaPagamento() : null) }}"
                readonly
            >

            <div class="input-group-append">
                <button
                    class="btn btn-primary btn-search"
                    type="button"
                    data-input="#forma_pagamento_id"
                    data-route="formas-pagamento"
                    data-toggle="modal"
                    data-target="#modal-formas-pagamento"
                >
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <div id="modal-formas-pagamento" class="modal fade" data-field="forma_pagamento" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header align-items-center py-2 bg-dark">
                    <h3 class="modal-title">Buscar Forma de Pagamento</h3>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    @include('formas-pagamento.search')
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-row">
    <div class="form-group required col-xl-2">
        <label>Parcela</label>
        <input
            type="number"
            id="parcela"
            name="parcela"
            min="1"
            oninput="validity.valid || (value = '');"
            class="form-control @error('parcela') is-invalid @enderror"
            value="{{ old('parcela', isset($contaPagar) ? $contaPagar->getParcela() : null) }}"
            required
        >

        <span class="invalid-feedback" role="alert" ref="parcela"></span>
    </div>

    <div class="form-group required col-xl-3">
        <label>Valor Parcela</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">R$</span>
            </div>

            <input
                type="number"
                id="valor_parcela"
                name="valor_parcela"
                placeholder="0,00"
                step=".01"
                min="1"
                oninput="validity.valid || (value = '');"
                class="form-control @error('valor_parcela') is-invalid @enderror"
                value="{{ old('valor_parcela', isset($contaPagar) ? $contaPagar->getValorParcela() : null) }}"
                required
            >

            @error('valor_parcela')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group required col-xl-3">
        <label>Data de Vencimento</label>
        <input
            type="date"
            id="data_vencimento"
            name="data_vencimento"
            class="form-control @error('data_vencimento') is-invalid @enderror"

            @isset($contaPagar)
                value="{{ old('data_emissao', $contaPagar->getDataVencimento()) }}"
                min="{{ $contaPagar->getDataEmissao() }}"
            @else
                value="{{ old('data_emissao', null) }}"
                min="{{ date('Y-m-d') }}"
            @endisset

            required
        >

        @error('data_vencimento')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group col-xl-3">
        <label>Data de Pagamento</label>
        <input
            type="date"
            id="data_pagamento"
            name="data_pagamento"
            class="form-control @error('data_pagamento') is-invalid @enderror"

            @isset($contaPagar)
                value="{{ old('data_pagamento', $contaPagar->getDataPagamento() ? $contaPagar->getDataPagamento() : $contaPagar->getDataEmissao()) }}"
                min="{{ $contaPagar->getDataEmissao() }}"
            @else
                value="{{ old('data_pagamento', null) }}"
                readonly
            @endisset
        >

        @error('data_pagamento')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-row">
    <div class="form-group col-xl-2">
        <label>Juros</label>

        <div class="input-group">
            <input
                type="number"
                id="juros"
                name="juros"
                placeholder="0"
                step=".01"
                min="0.01"
                max="100"
                oninput="validity.valid || (value = '');"
                class="form-control @error('juros') is-invalid @enderror"
                readonly
                @isset($contaPagar)
                    value="{{ old('juros', $contaPagar->getJuros() ? $contaPagar->getJuros() : null) }}"
                @endisset
            >

            <div class="input-group-append">
                <span class="input-group-text">%</span>
            </div>

            @error('juros')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group col-xl-3">
        <label>Multa</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">R$</span>
            </div>

            <input
                type="number"
                id="multa"
                name="multa"
                placeholder="0,00"
                step=".01"
                oninput="validity.valid || (value = '');"
                class="form-control @error('multa') is-invalid @enderror"
                readonly
                @isset($contaPagar)
                    value="{{ old('multa', $contaPagar->getMulta() ? $contaPagar->getMulta() : null) }}"
                @endisset
            >

            @error('multa')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group col-xl-3">
        <label>Desconto</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">R$</span>
            </div>

            <input
                type="number"
                id="desconto"
                name="desconto"
                placeholder="0,00"
                step=".01"
                min="0,01"
                oninput="validity.valid || (value = '');"
                readonly
                class="form-control @error('desconto') is-invalid @enderror"

                @isset($contaPagar)
                    max="{{ $contaPagar->getValorPago() }}"
                    value="{{ old('desconto', $contaPagar->getDesconto() ? $contaPagar->getDesconto() : null) }}"
                @endisset

                step=".01"
                oninput="validity.valid || (value = '');"
            >

            @error('desconto')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group required col-xl-3">
        <label>Valor Pago</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">R$</span>
            </div>

            <input
                type="number"
                id="valor_pago"
                name="valor_pago"
                placeholder="0,00"
                class="form-control @error('valor_pago') is-invalid @enderror"
                step=".01"
                required
                readonly

                @isset($contaPagar)
                    @if ($contaPagar->getStatus() == 'Em aberto')
                        value="{{ $contaPagar->getValorParcela() }}"
                    @else
                        value="{{ old('valor_pago', $contaPagar->getValorPago() ? $contaPagar->getValorPago() : null) }}"
                    @endif
                @else
                    value=""
                @endisset
            >

            @error('valor_pago')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

</div>
