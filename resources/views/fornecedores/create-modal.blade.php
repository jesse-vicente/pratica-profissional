<div id="modal-fornecedores-create" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header align-items-center py-2 bg-dark">
                <h3 class="modal-title">Cadastrar Fornecedor</h3>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('fornecedores.save') }}" data-route="fornecedores">
                    @csrf
                    @include('fornecedores.fields')
                </form>

                <div class="btn-group-lg d-flex justify-content-end">
                    <button class="btn btn-success btn-save-modal mr-2">
                        <span class="text-bold">Salvar</span>
                    </button>
                    <button class="btn btn-outline-secondary" data-dismiss="modal">
                        <span class="text-bold">Cancelar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@include('cidades.create-modal')
@include('condicoes-pagamento.create-modal')
