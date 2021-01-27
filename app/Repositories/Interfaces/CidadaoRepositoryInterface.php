<?php

namespace App\Repositories\Interfaces;

interface CidadaoRepositoryInterface
{
    public function inserirCidadao(string $nome, string $sobrenome, string $cpf);
    public function atualizarCidadao(int $id, string $nome, string $sobrenome, string $cpf);
    public function buscarCidadaoPeloCpf(string $cpf);
    public function deletarCidadao(int $id);
}
