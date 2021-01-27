<?php

namespace App\Repositories\Interfaces;

interface EnderecoRepositoryInterface
{
    public function buscarCidade(string $cidade);
    public function buscarUnidadeFederativa(string $uf);
    public function inserirUnidadeFederativa(string $uf);
    public function inserirCidade(string $nomeCidade, int $idUf);
    public function inserirEnderecoParaCidadao(string $cep, string $logradouro, string $bairro, int $idCidade, int $idCidadao);
    public function atualizarEnderecoParaCidadao(string $cep, string $logradouro, string $bairro, int $idCidade, int $idCidadao);
}
