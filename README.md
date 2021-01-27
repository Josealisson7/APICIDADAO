# API DE CIDADÃO

## Sobre o projeto

Projeto Laravel desenvolvido com o objetivo de criar uma API  para manipular dados de cidadão. O projeto foi desenvolvido com as seguintes tecnologias :

- [Laravel 6](https://laravel.com/docs/6.x/releases).
- [Guzzlephp](https://docs.guzzlephp.org/en/stable/).
- [SQLite](https://www.sqlite.org/index.html).

O projeto foi desenvolvido seguindo a arquitetura mvc, implementando também alguns patterns arquiteturais como :

- [Service Layer Pattern](https://en.wikipedia.org/wiki/Service_layer_pattern).
- [Repository Pattern](https://deviq.com/design-patterns/repository-pattern).

## Regras da aplicação

O sistema permite:
- Inserir (Não permitido cadastrar dois cidadãos com o mesmo CPF)
- Atualizar
- Deletar
- Consultar todos os cidadãos em ordem alfabética crescente
- Consultar um cidadão pelo CPF;
- Com o CEP as informações de logradouro, bairro, cidade e uf são buscadas no ViaCEP: https://viacep.com.br/ws/{cep}/json/

## Como usar o projeto


#### INSTALANDO DEPENDÊNCIAS:

Antes de inirciarmos precisamos instalar as dependêcias do projeto, vá até o diretorio do mesmo e execute o comando <b>composer install</b> no cmd.

#### INICIANDO O PROJETO:

Para iniciar o projeto no cmd execute o comando <b>php artisan serve</b>

## Rotas API

As rotas podem ser acessadas através de programas como o [Postman](https://www.postman.com/) ou qualquer outra forma de acesso a rotas de APIs que consigam simular requisições .

-> POST / CADASTRAR : http://127.0.0.1:8000/api/cidadao/

	Exemplo de JSON a ser integrado ao post :

	{
	"nome":"alisson",
	"sobrenome":"silva",
	"cpf":"12345678950",
	"celular": "71123456",
	"email": "meuemail@hotmail.com",
	"cep": "41300510"
	}



-> GET / LISTAR : http://127.0.0.1:8000/api/cidadao/


-> DELETE / EXCLUIR : http://127.0.0.1:8000/api/cidadao/{id}


-> GET / BUSCAR : http://127.0.0.1:8000/api/cidadao/{cpf}


-> PUT / ATUALIZAR : http://127.0.0.1:8000/api/cidadao/{id}


	Exemplo de JSON a ser integrado ao post :

	{
	"nome":"alisson atualizado",
	"sobrenome":"silva",
	"cpf":"12345678950",
	"celular": "71123456",
	"email": "meuemailatualizado@hotmail.com",
	"cep": "41300510"
	}




Obs: Ao inserir o cep a API faz uma requisição ao serviço [ViaCep](https://viacep.com.br/) para buscar dados como Bairro, Cidade e Estado, não sendo nescessário inserir esses dados ao cadastrar ou atualizar um cidadão.

## Armazenamento

Dentro do diretorio database existe um arquivo sqlite de nome database.sqlite onde são armazenado todas as informações cadastradas na API, lá você pode encontrar todas as tabelas e dados do projeto.


