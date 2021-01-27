<?php


namespace App\Services;

use App\Repositories\ContatoRepository;

class ContatoService
{
    private $contatoRepository;

    public function __construct(ContatoRepository $contatoRepository)
    {
        $this->contatoRepository = $contatoRepository;
    }

    /**
     * Metodo responsavel por encapsular a logica de criação de um contato para um cidadao.
     *
     * @return object
     *
     */

    public function criarUmContatoParaCidadao(string $celular, string $email, int $idCidadao)
    {
        $contato = $this->contatoRepository->inserirContatoParaCidadao($celular, $email, $idCidadao);
        if (!$contato){
            return response()->error("Erro ao criar um contato para cidadão", 400);
        }else{
            return response()->success($contato, 202);
        }
    }

    /**
     * Metodo responsavel por encapsular a logica de atualização de um contato para um cidadao.
     *
     * @return object
     *
     */

    public function atualizarUmContatoParaCidadao(string $celular, string $email, int $idCidadao)
    {
        $contato = $this->contatoRepository->atualizarContatoParaCidadao($celular, $email, $idCidadao);
        if (!$contato){
            return response()->error("Erro ao atualizar um contato para cidadão", 400);
        }else{
            return response()->success($contato, 200);
        }
    }
}
