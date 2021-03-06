<div class="form-row">
    <div class="form-group col-xl-2">
        <label>Código</label>
        <input
            type="number"
            id="id"
            name="id"
            class="form-control @error('id') is-invalid @enderror"
            value="{{ old('id', isset($estado) ? $estado->getId() : 0) }}"
            readonly
        >

        @error('id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group required col-xl-8">
        <label>Estado</label>
        <input
            type="text"
            id="estado"
            name="estado"
            class="form-control @error('estado') is-invalid @enderror"
            value="{{ old('estado', isset($estado) ? $estado->getEstado() : null) }}"
            maxlength="50"
            required
        >

        @error('estado')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group required col-xl-2">
        <label>UF</label>
        <input
            type="text"
            id="uf"
            name="uf"
            class="form-control @error('uf') is-invalid @enderror"
            value="{{ old('uf', isset($estado) ? $estado->getUF() : null) }}"
            required
        >

        @error('uf')
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
            class="form-control @error('pais_id') is-invalid @enderror"
            id="pais_id"
            name="pais_id"
            data-input="#pais"
            data-route="paises"
            value="{{ old('pais_id', isset($estado) ? $estado->getPais()->getId() : null) }}"
            min="1"
            step="1"
            oninput="validity.valid || (value = '');"
            required
        >

        @error('pais_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group required col-xl-10" id="ipt-pais">
        <label>País</label>
        <div class="input-group">
            <input
                type="text"
                class="form-control"
                id="pais"
                name="pais"
                value="{{ old('pais', isset($estado) ? $estado->getPais()->getPais() : null) }}"
                readonly
                required
                data-error="#ipt-pais"
            >

            <div class="input-group-append">
                <button
                    class="btn btn-primary btn-search"
                    type="button"
                    data-input="#pais_id"
                    data-route="paises"
                    data-toggle="modal"
                    data-target="#modal-paises"
                >
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <div id="modal-paises" data-field="pais" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="overlay">
                    <i class="fas fa-2x fa-sync fa-spin"></i>
                </div>
                <div class="modal-header align-items-center py-2 bg-dark">
                    <h3 class="modal-title">Buscar País</h3>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    @include('paises.search')
                </div>
            </div>
        </div>
    </div>
</div>
