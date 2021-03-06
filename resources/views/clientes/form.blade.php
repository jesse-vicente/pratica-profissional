<div class="card col-xl-7 p-0 mx-auto">
    <div class="card-header">
        <div class="d-flex align-items-center">
            @isset($cliente)
                <i class="fa fa-edit"></i>
                <h3 class="ml-3 mb-0">Alterar Cliente</h3>
            @else
                <i class="fa fa-plus"></i>
                <h3 class="ml-3 mb-0">Cadastrar Cliente</h3>
            @endif
        </div>
    </div>

    <div class="card-body">
        @isset($cliente)
            <form method="POST" action="{{ route('clientes.update', $cliente->getId()) }}">
            @method('PUT')
        @else
            <form method="POST" action="{{ route('clientes.store') }}">
        @endif

                @csrf
                @include('clientes.fields')

                <div class="d-flex justify-content-between border-top mt-4" style="padding-top: 1.25rem !important">
                    <div class="d-flex flex-column justify-content-center text-secondary">
                        <small><b>Cadastrado em: </b>{{ isset($cliente) ? $cliente->getDataCadastro() : "__/__/____" }}</small>
                        <small><b>Alterado em: </b>{{ isset($cliente) ? $cliente->getDataAlteracao() : "__/__/____" }}</small>
                    </div>

                    <div class="btn-group-lg">
                        <button type="submit" class="btn btn-success mr-2">
                            <span class="text-bold">Salvar</span>
                        </button>

                        <a class="btn btn-outline-secondary" href="{{ route('clientes.index') }}">
                            <span class="text-bold">Cancelar</span>
                        </a>
                    </div>
                </div>
            </form>
    </div>
</div>

@include('cidades.create-modal')
@include('condicoes-pagamento.create-modal')
