@extends('adminlte::page')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="fa fa-list"></i>
                <h4 class="ml-3 mb-0">Condições de Pagamento</h4>
            </div>

            <div class="float-right">
                <a href="{{ route('condicoes-pagamento.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Adicionar
                </a>
            </div>
        </div>
    </div>

    <div class="card-body">
        @include('condicoes-pagamento.table')
    </div>

</div>
@endsection
