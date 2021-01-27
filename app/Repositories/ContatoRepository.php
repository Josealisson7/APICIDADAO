<?php


namespace App\Repositories;

use App\Cidadao;
use App\Contato;
use App\Repositories\Interfaces\ContatoRepositoryInterface;

class ContatoRepository implements ContatoRepositoryInterface
{

    public function inserirContatoParaCidadao(string $celular, string $email, int $idCidadao)
    {
        $cidadao = Cidadao::find($idCidadao);
        if($cidadao) {
            $contato = new Contato();
            $contato->celular = $celular;
            $contato->email = $email;
            if($cidadao->contato()->save($contato)) {
                return $cidadao->contato()->get();
            }
        }
        return false;
    }

    public function atualizarContatoParaCidadao(string $celular, string $email, int $idCidadao)
    {
        $contato = Contato::where(['cidadao_id' => $idCidadao])->first();
        if($contato) {
            $contato->celular = $celular;
            $contato->email = $email;
            if($contato->save()) {
                return $contato;
            }
        }
        return false;
    }

}
