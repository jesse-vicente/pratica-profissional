<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            @isset($venda)
                <i class="fa fa-edit"></i>
                <h3 class="ml-3 mb-0">Alterar Venda</h3>
            @else
                <i class="fa fa-plus"></i>
                <h3 class="ml-3 mb-0">Cadastrar Venda</h3>
            @endif
        </div>
    </div>

    <div class="card-body">
        @isset($venda)
            <form method="POST" action="{{ route('vendas.update', $venda->getId()) }}">
            @method('PUT')
        @else
            <form method="POST" action="{{ route('vendas.store') }}">
        @endif

            @csrf
            @include('vendas.fields')
            </form>
    </div>
</div>

<div class="d-flex justify-content-end flex-column align-items-xl-end mb-3">
    <small><b>Cadastrado em: </b>{{ isset($venda) ? $venda->getDataCadastro() : "__/__/____" }}</small>
    <small><b>Alterado em: </b>{{ isset($venda) ? $venda->getDataAlteracao() : "__/__/____" }}</small>
</div>

@include('vendas.actions')
