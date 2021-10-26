# Loja Virtual API
## Teste prático de PHP

## Requisitos
Para executar a aplicação, são necessários os seguintes sistemas instalados:
- Docker
- Composer

## Instalação

Baixe o repositório
- git clone https://github.com/marcelomileris/lojavirtual.git

Dentro da pasta do projeto execute o comando para iniciar o Docker
- docker-compose up -d

Acessar a pasta www/src e executar o comando para atualizar as dependências do projeto
- composer update

## Como usar
A API é acessada através da url
~~~ 
[GET] https://localhost:8000/user/{id} // Caso não seja informado o ID, lista todos usuários cadastros
[POST] https://localhost:8000/user
[PUT] https://localhost:8000/user
[DELETE] https://localhost:8000/user/:id
~~~

Enviar os dados via JSON ou FormData. Exemplo:
~~~
{
    "name":"Fulano de tal",
    "email":"fulaninho@gmail.com",
    "birth":"1987-03-14",
    "phone":"19987412125",
    "document":"36985214710",
    "zip_code":"13344321",
    "number" : "123"
}
~~~
Não há necessidade de enviar o endereço completo para cadastro/update, pois o mesmo recupera as informações através do viacep (https://viacep.com.br/).
Retorno:
~~~
{
    "status":"sucess",
    "data":{
        "id":6,
        "name":"Fulano de tal",
        "email":"fulaninho@gmail.com",
        "birth":"1987-03-14",
        "phone":"19987412125",
        "document":"36985214710",
        "zip_code":"13344321",
        "address":"Rua Basílio Martins",
        "number":"123",
        "district":"Jardim Califórnia",
        "city":"Indaiatuba",
        "estate":"SP"
    }
}
~~~



**Marcelo Mileris**
