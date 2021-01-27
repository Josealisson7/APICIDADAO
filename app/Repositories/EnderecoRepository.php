<?php


namespace App\Repositories;

use App\Cidadao;
use App\Cidade;
use App\Endereco;
use App\Repositories\Interfaces\EnderecoRepositoryInterface;
use App\UnidadeFederativa;

class EnderecoRepository implements EnderecoRepositoryInterface
{

    public function buscarCidade(string $cidade)
    {
        return Cidade::where('cidade', $cidade)->first();
    }

    public function buscarUnidadeFederativa(string $uf)
    {
        return UnidadeFederativa::where('uf', $uf)->first();
    }

    public function inserirUnidadeFederativa(string $uf)
    {
        $unidadeFederativa = new UnidadeFederativa();
        $unidadeFederativa->uf = $uf;
        if($unidadeFederativa->save()){
            return $unidadeFederativa;
        }
    }

    public function inserirCidade(string $nomeCidade, int $idUf)
    {
        $cidade = new Cidade();
        $cidade->cidade = $nomeCidade;
        $cidade->unidade_federativa_id = $idUf;
        if($cidade->save()){
            return $cidade;
        }
    }

    public function inserirEnderecoParaCidadao(string $cep, string $logradouro, string $bairro, int $idCidade, int $idCidadao)
    {
        $cidade = Cidade::find($idCidade);
        $cidadao = Cidadao::find($idCidadao);
        if ($cidade && $cidadao) {
            $endereco = new Endereco();
            $endereco->cep = $cep;
            $endereco->logradouro = $logradouro;
            $endereco->bairro = $bairro;
            $endereco->cidade_id = $idCidade;
            $endereco->cidadao_id = $idCidadao;
            if ($endereco->save()){
                return $endereco;
            }
        }
        return false;
    }

    public function atualizarEnderecoParaCidadao(string $cep, string $logradouro, string $bairro, int $idCidade, int $idCidadao)
    {
        $endereco = Endereco::where(['cidadao_id' => $idCidadao])->first();
        $cidade = Cidade::find($idCidade);;
        if ($cidade && $endereco) {
            $endereco->cep = $cep;
            $endereco->logradouro = $logradouro;
            $endereco->bairro = $bairro;
            $endereco->cidade_id = $idCidade;
            $endereco->cidadao_id = $idCidadao;
            if ($endereco->save()){
                return $endereco;
            }
        }
        return false;
    }

}
