
<div class="form-row">
    <div class="form-group col-xl-1">
        <label>Código</label>
        <input
            type="text"
            id="id"
            name="id"
            class="form-control @error('id') is-invalid @enderror"
            value="{{ old('id', isset($cidade) ? $cidade->getId() : null) }}"
            readonly
        >

        @error('id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group required col-xl-2">
        <label>Cidade</label>
        <input
            type="text"
            id="cidade"
            name="cidade"
            class="form-control @error('cidade') is-invalid @enderror"
            value="{{ old('cidade', isset($cidade) ? $cidade->getCidade() : null) }}"
        >

        @error('cidade')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group required col-xl-1">
        <label>DDD</label>
        <input
            type="number"
            id="ddd"
            name="ddd"
            class="form-control @error('ddd') is-invalid @enderror"
            value="{{ old('ddd', isset($cidade) ? $cidade->getDDD() : null) }}"
        >

        @error('ddd')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-row">
    <div class="form-group col-xl-1">
        <label>Cód. Estado</label>
        <input
            type="text"
            class="form-control"
            name="estado_id"
            id="estado_id"
            data-input="#estado"
            data-route="estados"
            value="{{ old('estado_id', isset($cidade) ? $cidade->getEstado()->getId() : null) }}"
        >
    </div>

    <div class="form-group required col-xl-3">
        <label>Estado</label>
        <div class="input-group mb-3">

            <input
                type="text"
                class="form-control @error('estado_id') is-invalid @enderror"
                name="estado"
                id="estado"
                value="{{ old('estado', isset($cidade) ? $cidade->getEstado()->getEstado() : null) }}"
                readonly
                required
            >

            <div class="input-group-append">
                <button
                    class="btn btn-primary btn-search"
                    type="button"
                    data-input="#estado_id"
                    data-route="estados"
                    data-toggle="modal"
                    data-target="#modal-estados"
                >
                    <i class="fa fa-search"></i>
                </button>
            </div>

            @error('estado_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div id="modal-estados" class="modal fade" data-field="estado" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header align-items-center py-2">
                    <h3 class="modal-title">Buscar Estado</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive"></div>
                </div>
            </div>
        </div>
    </div>
</div>
