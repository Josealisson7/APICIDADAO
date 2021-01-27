<?php


namespace App\Services;
use App\Repositories\EnderecoRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use function PHPUnit\Framework\throwException;

class EnderecoService
{
    private $client;
    private $enderecoRepository;

    public function __construct(EnderecoRepository $enderecoRepository)
    {
        $this->client = new Client();
        $this->enderecoRepository = $enderecoRepository;
    }

    /**
     * Busca os dados de endereço pelo Cep atraves de um serviço.
     *
     * @return object
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     */

    public function buscarEnderecoPeloCep(string $cep)
    {
        try {
            $request = $this->client->get("https://viacep.com.br/ws/{$cep}/json/");
            $response = $request->getBody();
            $endereco = $response->getContents();
            if(property_exists(json_decode($endereco), 'erro')){
                throw new \Exception('Cep não encontrado', 404);
            }
            return response()->success($endereco);
        }catch (\Exception $e){
            return response()->error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Metodo responsavel por encapsular a logica de criação de um endereço para um cidadao.
     *
     * @return object
     *
     */

    public function criarUmEnderecoParaCidadao(string $cep, string $logradouro, string $bairro, string $cidade, string $uf, int $idCidadao)
    {
        $unidadeFederativaDados = $this->enderecoRepository->buscarUnidadeFederativa($uf);
        if(empty($unidadeFederativaDados)){
            $unidadeFederativaDados = $this->enderecoRepository->inserirUnidadeFederativa($uf);
        }
        $cidadeDados = $this->enderecoRepository->buscarCidade($cidade);
        if (empty($cidadeDados)){
            $cidadeDados = $this->enderecoRepository->inserirCidade($cidade, $unidadeFederativaDados->id);
        }
        $endereco = $this->enderecoRepository->inserirEnderecoParaCidadao($cep, $logradouro, $bairro, $cidadeDados->id, $idCidadao);
        if (!$endereco){
            return response()->error("erro ao criar um endereço para cidadão", 400);
        }else{
            return response()->success($endereco, 202);
        }
    }

    /**
     * Metodo responsavel por encapsular a logica de atualização de um endereço para um cidadao.
     *
     * @return object
     *
     */

    public function atualizarUmEnderecoParaCidadao(string $cep, string $logradouro, string $bairro, string $cidade, string $uf, int $idCidadao)
    {
        $unidadeFederativaDados = $this->enderecoRepository->buscarUnidadeFederativa($uf);
        if(empty($unidadeFederativaDados)){
            $unidadeFederativaDados = $this->enderecoRepository->inserirUnidadeFederativa($uf);
        }
        $cidadeDados = $this->enderecoRepository->buscarCidade($cidade);

        if (empty($cidadeDados)){
            $cidadeDados = $this->enderecoRepository->inserirCidade($cidade, $unidadeFederativaDados->id);
        }
        $endereco = $this->enderecoRepository->atualizarEnderecoParaCidadao($cep, $logradouro, $bairro, $cidadeDados->id, $idCidadao);
        if (!$endereco){
            return response()->error("erro ao atualizar um endereço para cidadão", 400);
        }else{
            return response()->success($endereco, 202);
        }
    }
}
