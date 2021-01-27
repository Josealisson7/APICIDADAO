<?php

namespace App\Repositories\Interfaces;

interface ContatoRepositoryInterface
{
    public function inserirContatoParaCidadao(string $celular, string $email, int $idCidadao);
    public function atualizarContatoParaCidadao(string $celular, string $email, int $idCidadao);
}
