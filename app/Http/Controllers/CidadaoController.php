<?php

namespace App\Http\Controllers;

use App\Repositories\CidadaoRepository;
use App\Services\CidadaoService;
use Illuminate\Http\Request;

class CidadaoController extends Controller
{
    public function cadastrar(Request $request)
    {
        $cidadaoService = app(CidadaoService::class);
        $resposta = $cidadaoService->criarUmCidadao($request->nome, $request->sobrenome, $request->cpf, $request->celular, $request->email, $request->cep);
        if($resposta->getData()->errors){
            return response()->json(
                [
                    "status" => $resposta->status(),
                    "message" => $resposta->getData()->message
                ],
                $resposta->status(), array(), JSON_PRETTY_PRINT
            )->content();
        }else{
            return response()->json(
                [
                    "status" => 202,
                    "message" => 'Cidadão cadastrado com sucesso'
                ],
                202, array(), JSON_PRETTY_PRINT
            )->content();
        }
    }

    public function listar()
    {
        $cidadaoRepository = new CidadaoRepository();
        $cidadaos = $cidadaoRepository->listarTodos();
        return response()->json(
            [
                "status" => 200,
                "data" => $cidadaos
            ],
            200, array(), JSON_PRETTY_PRINT
        );
    }

    public function deletar(int $id)
    {
        try {
            $cidadaoRepository = new CidadaoRepository();
            if($cidadaoRepository->deletarCidadao($id)){
                return response()->json(
                    [
                        "status" => 200,
                        "message" => "Cidadao deletado com sucesso"
                    ],
                    200, array(), JSON_PRETTY_PRINT
                );
            }else {
                throw new \Exception('Erro ao deletar cidadao');
            }
        }catch (\Exception $e){
            return response()->json(
                [
                    "status" => 400,
                    "message" => $e->getMessage()
                ],
                400, array(), JSON_PRETTY_PRINT
            );
        }
    }

    public function atualizar(Request $request, int $id)
    {

        $cidadaoService = app(CidadaoService::class);
        $resposta = $cidadaoService->atualizarUmCidadao($request->nome, $request->sobrenome, $request->cpf, $request->celular, $request->email, $request->cep, $id);
        if($resposta->getData()->errors){
            return response()->json(
                [
                    "status" => $resposta->status(),
                    "message" => $resposta->getData()->message
                ],
                $resposta->status(), array(), JSON_PRETTY_PRINT
            )->content();
        }else{
            return response()->json(
                [
                    "status" => 200,
                    "message" => 'Cidadão atualizado com sucesso'
                ],
                200, array(), JSON_PRETTY_PRINT
            )->content();
        }
    }

    public function buscar(string $cpf)
    {
        $cidadaoRepository = new CidadaoRepository();
        $cidadao = $cidadaoRepository->buscarCidadaoPeloCpf($cpf);
        return response()->json(
            [
                "status" => 200,
                "data" => $cidadao
            ],
            200, array(), JSON_PRETTY_PRINT
        );
    }
}
