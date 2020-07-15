<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            @isset($produto)
                <i class="fa fa-edit"></i>
                <h3 class="ml-3 mb-0">Alterar Produto</h3>
            @else
                <i class="fa fa-plus"></i>
                <h3 class="ml-3 mb-0">Cadastrar Produto</h3>
            @endif
        </div>
    </div>

    <div class="card-body">
        @isset($produto)
            <form method="POST" action="{{ route('produtos.update', $produto->getId()) }}">
            @method('PUT')
        @else
            <form method="POST" action="{{ route('produtos.store') }}">
        @endif

            @csrf
            @include('produtos.fields')
            </form>
    </div>
</div>

<div class="d-flex justify-content-end flex-column align-items-xl-end mb-3">
    <small><b>Cadastrado em: </b>{{ isset($produto) ? $produto->getDataCadastro() : "__/__/____" }}</small>
    <small><b>Alterado em: </b>{{ isset($produto) ? $produto->getDataAlteracao() : "__/__/____" }}</small>
</div>

@include('produtos.actions')