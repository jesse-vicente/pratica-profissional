@extends('adminlte::page')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="fa fa-list"></i>
                <h4 class="ml-3 mb-0">Produtos</h4>
            </div>

            <div class="float-right">
                <a href="{{ route('produtos.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Adicionar
                </a>
            </div>
        </div>
    </div>

    <div class="card-body">
        @include('produtos.table')
    </div>

</div>
@endsection
