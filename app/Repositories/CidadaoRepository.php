<?php


namespace App\Repositories;

use App\Cidadao;
use App\Repositories\Interfaces\CidadaoRepositoryInterface;

class CidadaoRepository implements CidadaoRepositoryInterface
{

    public function inserirCidadao(string $nome, string $sobrenome, string $cpf)
    {
        $cidadao = new Cidadao();
        $cidadao->nome = $nome;
        $cidadao->sobrenome = $sobrenome;
        $cidadao->cpf = $cpf;
        if($cidadao->save()){
            return $cidadao;
        }
        return false;
    }

    public function atualizarCidadao(int $id, string $nome, string $sobrenome, string $cpf)
    {
        $cidadao = Cidadao::find($id);
        if($cidadao){
            $cidadao->nome = $nome;
            $cidadao->sobrenome = $sobrenome;
            $cidadao->cpf = $cpf;
            if($cidadao->save()){
                return $cidadao;
            }
        }
        return false;
    }

    public function buscarCidadaoPeloCpf(string $cpf)
    {
        $cidadao = Cidadao::where(['cpf' => $cpf])->with('endereco.cidade.unidadeFederativa')->first();
        if($cidadao){
           return $cidadao;
        }
    }

    public function listarTodos()
    {
       return Cidadao::with('endereco.cidade.unidadeFederativa')->orderBy('nome', 'asc')->get(['*']);
    }

    public function deletarCidadao(int $id)
    {
        $cidadao = Cidadao::find($id);
        if($cidadao){
            $cidadao->endereco()->delete();
            return $cidadao->delete();
        }
    }

}
