<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FormaPagamentoRequest;

use App\Http\Dao\DaoFormaPagamento;

class FormaPagamentoController extends Controller
{
    private DaoFormaPagamento $daoFormaPagamento;

    public function __construct()
    {
        $this->daoFormaPagamento = new DaoFormaPagamento();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formasPagamento = $this->daoFormaPagamento->all(true);
        return view('formas-pagamento.index', compact('formasPagamento'));
    }

    public function all()
    {
        $formasPagamento = $this->daoFormaPagamento->all();
        return $formasPagamento;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('formas-pagamento.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\FormaPagamentoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormaPagamentoRequest $request)
    {
        $formaPagamento = $this->daoFormaPagamento->create($request->all());

        $store = $this->daoFormaPagamento->store($formaPagamento);

        if ($store)
            return redirect('formas-pagamento') ->with('success', 'Registro inserido com sucesso!');

        return redirect('formas-pagamento')->with('error', 'Erro ao inserir registro.');
    }

    public function save(FormaPagamentoRequest $request)
    {
        $formaPagamento = $this->daoFormaPagamento->create($request->all());

        $store = $this->daoFormaPagamento->store($formaPagamento);

        if ($store) {
            return response()->json([
                'success' => true,
                'message' => 'Registro inserido com sucesso!'
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Erro ao inserir registro!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $formaPagamento = $this->daoFormaPagamento->findById($id, true);

        if ($formaPagamento)
            return view('formas-pagamento.show', compact('formaPagamento'));

        return redirect('formas-pagamento')->with('error', 'Registro não encontrado.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $formaPagamento = $this->daoFormaPagamento->findById($id, true);

        if ($formaPagamento)
            return view('formas-pagamento.create', compact('formaPagamento'));

        return redirect('formas-pagamento')->with('error', 'Registro não encontrado.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\FormaPagamentoRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FormaPagamentoRequest $request, $id)
    {
        $update = $this->daoFormaPagamento->update($request, $id);

        if ($update)
            return redirect('formas-pagamento') ->with('success', 'Registro alterado com sucesso!');

        return redirect('formas-pagamento')->with('error', 'Erro ao alterar registro.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = $this->daoFormaPagamento->delete($id);

        if ($delete)
            return redirect('formas-pagamento')->with('success', 'Registro removido com sucesso!');

        return redirect('formas-pagamento')->with('error', 'Este registro não pode ser removido.');
    }

    public function findById(int $id) {
        $formaPagamento = $this->daoFormaPagamento->findById($id);

        return [ $formaPagamento ];
    }
}
