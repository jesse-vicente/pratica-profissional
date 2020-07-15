@extends('adminlte::page')

@section('content')
<div class="card">
    <div class="card-header bg-danger">
        <div class="d-flex align-items-center">
            <i class="fa fa-trash-alt"></i>
            <h3 class="ml-3 mb-0">Excluir Cidade</h3>
        </div>
    </div>

    <div class="card-body">
        @isset($cidade)
        <form method="POST" action="{{ route('cidades.destroy', $cidade->getId()) }}" id="form-delete">
            @csrf
            @method('DELETE')

            @include('cidades.fields')
        </form>

        @else
        <span>Registro não encontrado.</span>
        @endif
    </div>
</div>

<div class="form-row d-flex flex-row-reverse pb-5">
    <button type="button" class="btn btn-danger ml-2" id="delete-entry">
        <i class="fa fa-trash-alt mr-1"></i>
        <span>Excluir</span>
    </button>

    <a class="btn btn-secondary" href="{{ route('cidades.index') }}">
        <i class="fa fa-undo mr-1"></i>
<span>Voltar</span>
    </a>
</div>
@endsection