<?php

namespace App\Http\Dao;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Dao\Dao;
use App\Http\Dao\DaoParcela;

use App\Http\Models\CondicaoPagamento;

class DaoCondicaoPagamento implements Dao {

    private DaoParcela $daoParcela;

    public function __construct()
    {
        $this->daoParcela = new DaoParcela();
    }

    public function all(bool $model = false) {
        if (!$model)
            return DB::table('condicoes_pagamento')->get(['id', 'condicao_pagamento', 'juros', 'multa', 'desconto']);

        $itens = DB::table('condicoes_pagamento')->orderBy('condicao_pagamento', 'desc')->get();

        $condicoesPagamento = array();

        foreach ($itens as $item) {
            $condicaoPagamento = $this->create(get_object_vars($item));
            array_push($condicoesPagamento, $condicaoPagamento);
        }

        return $condicoesPagamento;
    }

    public function create(array $dados) {

        $condicaoPagamento = new CondicaoPagamento();

        if (isset($dados["id"])) {
            $condicaoPagamento->setId($dados["id"]);
            $condicaoPagamento->setDataCadastro($dados["data_cadastro"] ?? null);
            $condicaoPagamento->setDataAlteracao($dados["data_alteracao"] ?? null);
        }

        // dd($dados["juros"]);

        $condicaoPagamento->setJuros((float) $dados["juros"]);
        $condicaoPagamento->setMulta((float) $dados["multa"]);
        $condicaoPagamento->setDesconto((float) $dados["desconto"]);
        $condicaoPagamento->setCondicaoPagamento($dados["condicao_pagamento"]);

        $totalParcelas = isset($dados["parcelas"]) ? count($dados["parcelas"]) : $dados["total_parcelas"];

        // Gerar parcelas
        if ($totalParcelas > 0) {

            $parcelas = array();
            $dadosParcelas = array();

            if (isset($dados["parcelas"])) {
                $dadosParcelas = [
                    "parcelas"           => $dados["parcelas"],
                    "numero"             => $dados["parcelas"],
                    "prazo"              => $dados["prazo"],
                    "porcentagem"        => $dados["porcentagem"],
                    "forma_pagamento_id" => $dados["forma_pagamento_id"],
                ];

                $parcelas = $this->gerarParcelas($dadosParcelas, $condicaoPagamento);
            }
            else if ($condicaoPagamento->getId() > 0) {
                $parcelas = $this->buscarParcelas($condicaoPagamento->getId());
            }

            $condicaoPagamento->setParcelas($parcelas);
        }

        $condicaoPagamento->setTotalParcelas($totalParcelas);

        // dd($condicaoPagamento);

        return $condicaoPagamento;
    }

    public function gerarParcelas($dadosParcelas, $condicaoPagamento) {
        $parcelas = array();

        foreach ($dadosParcelas["parcelas"] as $i => $item) {

            $dadosParcela = [
                "numero"             => $dadosParcelas["parcelas"][$i],
                "prazo"              => $dadosParcelas["prazo"][$i],
                "porcentagem"        => $dadosParcelas["porcentagem"][$i],
                "forma_pagamento_id" => $dadosParcelas["forma_pagamento_id"][$i],
            ];

            $parcela = $this->daoParcela->create($dadosParcela);

            array_push($parcelas, $parcela);
        }

        return $parcelas;
    }

    public function store($condicaoPagamento) {
        DB::beginTransaction();

        try {
            $dados = $this->getData($condicaoPagamento);

            DB::table('condicoes_pagamento')->insert($dados);

            if ($condicaoPagamento->getTotalParcelas() > 0) {
                $idCondicaoPagamento = DB::getPdo()->lastInsertId();
                $this->salvarParcelas($condicaoPagamento->getParcelas(), $idCondicaoPagamento);
            }

            DB::commit();

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            return false;
        }
    }

    public function salvarParcelas(array $parcelas, $idCondicaoPagamento) {
        foreach ($parcelas as $parcela) {
            $dadosParcela = [
                'numero'                => $parcela->getNumero(),
                'prazo'                 => $parcela->getPrazo(),
                'porcentagem'           => $parcela->getPorcentagem(),
                'forma_pagamento_id'    => $parcela->getFormaPagamento()->getId(),
                'condicao_pagamento_id' => $idCondicaoPagamento,
            ];

            DB::beginTransaction();

            try {
                if ($parcela->getId() > 0) {
                    DB::table('parcelas')->where('id', $parcela->getId())->update($dadosParcela);
                    DB::commit();
                } else {
                    DB::table('parcelas')->insert($dadosParcela);
                    DB::commit();
                }
            } catch (\Throwable $th) {
                dd($th->getMessage());
            }
        }
    }

    public function update(Request $request, $id) {
        DB::beginTransaction();

        try {

            $condicaoPagamento = $this->create($request->all());

            $dados = $this->getData($condicaoPagamento);

            DB::table('condicoes_pagamento')->where('id', $id)->update($dados);

            if ($condicaoPagamento->getTotalParcelas() > 0) {
                $parcelasCadastradas = $this->buscarParcelas($id);

                if (count($parcelasCadastradas) > 0)
                    DB::table('parcelas')->where('condicao_pagamento_id', $id)->delete();

                $this->salvarParcelas($condicaoPagamento->getParcelas(), $id);
            } else {
                DB::table('parcelas')->where('condicao_pagamento_id', $id)->delete();
            }

            DB::commit();

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            return false;
        }
    }

    public function delete($id) {
        DB::beginTransaction();

        try {
            $condicaoPagamento = $this->findById($id, true);

            if ($condicaoPagamento->getTotalParcelas() != 0)
                DB::table('parcelas')->where('condicao_pagamento_id', $id)->delete();

            DB::table('condicoes_pagamento')->delete($id);

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    public function findById(int $id, bool $model = false) {
        if (!$model) {
            $query = DB::table('condicoes_pagamento', 'cp')
                       ->join('parcelas as p', 'cp.id', '=', 'p.condicao_pagamento_id')
                       ->join('formas_pagamento as fp', 'p.forma_pagamento_id', '=', 'fp.id')
                       ->get(['cp.id', 'cp.condicao_pagamento', 'cp.juros', 'cp.multa', 'cp.desconto', 'cp.total_parcelas', 'fp.forma_pagamento'])
                       ->where('id', $id)
                       ->first();

            return $query;
        }

        $dados = DB::table('condicoes_pagamento')->where('id', $id)->first();

        if ($dados)
            return $this->create(get_object_vars($dados));

        return $dados;
    }

    public function buscarParcelas($idCondicaoPagamento) {
        $dados = DB::table('parcelas')->where('condicao_pagamento_id', $idCondicaoPagamento)->get();

        $parcelas = array();

        foreach ($dados as $dadosParcela) {
            $parcela = $this->daoParcela->create(get_object_vars($dadosParcela));
            array_push($parcelas, $parcela);
        }

        return $parcelas;
    }

    public function getData(CondicaoPagamento $condicaoPagamento) {
        $dados = [
            'id'                 => $condicaoPagamento->getId(),
            'condicao_pagamento' => $condicaoPagamento->getCondicaoPagamento(),
            'juros'              => $condicaoPagamento->getJuros(),
            'multa'              => $condicaoPagamento->getMulta(),
            'desconto'           => $condicaoPagamento->getDesconto(),
            'total_parcelas'     => $condicaoPagamento->getTotalParcelas(),
        ];

        return $dados;
    }

    public function fillForModal(CondicaoPagamento $condicaoPagamento) {
        $dados = [
            'id'             => $condicaoPagamento->getId(),
            'nome'           => $condicaoPagamento->getCondicaoPagamento(),
            'juros'          => $condicaoPagamento->getJuros(),
            'multa'          => $condicaoPagamento->getMulta(),
            'desconto'       => $condicaoPagamento->getDesconto(),
            'total_parcelas' => $condicaoPagamento->getTotalParcelas(),
        ];

        if ($condicaoPagamento->getTotalParcelas() > 0) {
            $listaParcelas = array();
            $parcelas = $condicaoPagamento->getParcelas();

            foreach ($parcelas as $parcela) {
                $dadosParcela = $this->daoParcela->fillForModal($parcela);
                array_push($listaParcelas, $dadosParcela);
            }

            $dados['parcelas'] = $listaParcelas;
        }

        return $dados;
    }
}
