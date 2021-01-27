<?php


namespace App\Services;

use App\Repositories\CidadaoRepository;
use Illuminate\Support\Facades\DB;

class CidadaoService
{
    private $cidadaoRepository;

    public function __construct(CidadaoRepository $cidadaoRepository)
    {
        $this->cidadaoRepository = $cidadaoRepository;
    }

    /**
     * Metodo responsavel por encapsular a logica de criação de um cidadao.
     *
     * @return object
     *
     */

    public function criarUmCidadao(string $nome, string $sobrenome, string $cpf, string $celular, string $email, string $cep)
    {
        $enderecoService = app(EnderecoService::class);
        $contatoService = app(ContatoService::class);
        $resposta = $enderecoService->buscarEnderecoPeloCep($cep);
        if($resposta->getData()->errors){
            return $resposta->throwResponse();
        }
        $endereco = json_decode($resposta->getData()->data);
        DB::beginTransaction();
        try {
            if ($this->cidadaoRepository->buscarCidadaoPeloCpf($cpf)){
                throw new \Exception("Cpf já cadastrado na base de dados", 400);
            }
            $novoCidadao = $this->cidadaoRepository->inserirCidadao($nome, $sobrenome, $cpf);
            if($novoCidadao){
                $novoContato = $contatoService->criarUmContatoParaCidadao($celular, $email, $novoCidadao->id);
                $cep = str_replace('-','',$endereco->cep);
                $novoEndereco = $enderecoService->criarUmEnderecoParaCidadao($cep, $endereco->logradouro, $endereco->bairro, $endereco->localidade, $endereco->uf, $novoCidadao->id);
                if($novoContato->getData()->errors == false && $novoEndereco->getData()->errors == false){
                    DB::commit();
                    return response()->success($novoCidadao, 202);
                }
            }
            throw new \Exception("Erro ao inserir um novo cidadão", 500);
        }catch (\Exception $e){
            DB::rollback();
            $status = $e->getCode() != 400 ? 500 : $e->getCode();
            return response()->error($e->getMessage(), $status);
        }
    }

    /**
     * Metodo responsavel por encapsular a logica de atualização de um cidadao.
     *
     * @return object
     *
     */

    public function atualizarUmCidadao(string $nome, string $sobrenome, string $cpf, string $celular, string $email, string $cep, int $id)
    {
        $enderecoService = app(EnderecoService::class);
        $contatoService = app(ContatoService::class);
        $resposta = $enderecoService->buscarEnderecoPeloCep($cep);
        if($resposta->getData()->errors){
            return $resposta->throwResponse();
        }
        $endereco = json_decode($resposta->getData()->data);
        DB::beginTransaction();
        try {
            if ($cidadao = $this->cidadaoRepository->buscarCidadaoPeloCpf($cpf)){
                if ($cidadao->id != $id){
                    throw new \Exception("Cpf já esta associado a outro cidadão na base de dados", 400);
                }
            }
            $cidadaoAtualizado = $this->cidadaoRepository->atualizarCidadao($id,$nome, $sobrenome, $cpf);
            if (!$cidadaoAtualizado) {
                throw new \Exception("Cidadão não encontrado na base de dados", 400);
            }
            $contatoAtualizado = $contatoService->atualizarUmContatoParaCidadao($celular, $email, $cidadaoAtualizado->id);
            $enderecoAtualizado = $enderecoService->atualizarUmEnderecoParaCidadao(str_replace('-','',$endereco->cep), $endereco->logradouro, $endereco->bairro, $endereco->localidade, $endereco->uf, $cidadaoAtualizado->id);
            if($contatoAtualizado->getData()->errors == false && $enderecoAtualizado->getData()->errors == false) {
                DB::commit();
                return response()->success($cidadaoAtualizado, 202);
            }
            throw new \Exception("Erro ao atualizar cidadão");
        }catch (\Exception $e){
            DB::rollback();
            $status = $e->getCode() != 400 ? 500 : $e->getCode();
            return response()->error($e->getMessage(), $status);
        }
    }
}
