# Meu Projeto Laravel com Livewire

Este projeto é uma aplicação web desenvolvida em Laravel, utilizando Livewire no front-end para consumir a API.
O objetivo do sistema é fornecer um sistema  é realizar o gerenciamento de "Produtos".

A aplicação oferece as seguintes funcionalidades principais:

* **Gerenciamento de Produtos:** Permite a criação, leitura, atualização e exclusão (CRUD) de produtos, cada um contendo nome (único e obrigatório), descrição (opcional), preço (obrigatório e positivo) e quantidade em estoque (obrigatória e não negativa).
* **Interface Web Completa:** Uma interface web intuitiva com listagem paginada, funcionalidade de busca e formulários para todas as operações CRUD, com validações tanto no frontend quanto no backend.
* **API RESTful Protegida:** Uma API RESTful para realizar as mesmas operações CRUD sobre produtos, protegida por autenticação e com uma estrutura de resposta padronizada.
* **Sistema de Autenticação:** Implementação de login e senha para proteger o acesso à interface web e à API.
* **Ambiente Dockerizado:** Configuração completa de um ambiente de desenvolvimento utilizando Docker, incluindo a aplicação Laravel e um banco de dados MySQL.
* **Testes Automatizados:** Implementação de testes unitários e de integração para garantir a robustez e a qualidade do código.


## Como rodar a aplicação

Siga estes passos para executar a aplicação utilizando Docker:

1.  Clone este repositório para a sua máquina local:
    ```bash
    git clone [https://github.com/emanuelluzia/listagem-produto-livewire.git](https://github.com/emanuelluzia/listagem-produto-livewire.git)
    cd seu-repositorio
    ```
2.  Execute o seguinte comando para iniciar os containers Docker:
    ```bash
    docker-compose up -d
    ```
3.  Acesse o container da aplicação para executar os comandos do Artisan:
    ```bash
    docker-compose exec app bash
    ```
4.  Dentro do container, instale as dependências do Composer:
    ```bash
    composer install
    ```
5.  Copie o arquivo de ambiente e gere a chave da aplicação:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
6.  Execute as migrations e os seeders (se houver):
    ```bash
    php artisan migrate --seed
    ```
7.  A aplicação estará disponível em seu navegador no endereço: `http://localhost:8000`.

## Como rodar os testes

Para executar os testes da aplicação, utilize o seguinte comando no seu terminal, dentro do diretório raiz do projeto:

```bash
docker-compose exec app php artisan test