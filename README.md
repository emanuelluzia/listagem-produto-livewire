# Meu Projeto Laravel com Livewire

Este projeto é uma aplicação web desenvolvida em Laravel, utilizando Livewire no front-end para consumir a API.
O objetivo do sistema é fornecer um sistema  é realizar o gerenciamento de "Produtos".

A aplicação oferece as seguintes funcionalidades principais:

* **Gerenciamento de Produtos:** Permite a criação, leitura, atualização e exclusão (CRUD) de produtos, cada um contendo nome (único e obrigatório), descrição (opcional), preço (obrigatório e positivo) e quantidade em estoque (obrigatória e não negativa).

* **API RESTful Protegida:** Uma API RESTful para realizar as mesmas operações CRUD sobre produtos, protegida por autenticação e com uma estrutura de resposta padronizada.
* **Sistema de Autenticação:** Implementação de login e senha para proteger o acesso à interface web e à API.
 ![image](https://github.com/user-attachments/assets/e7d3f08b-1eeb-4514-8fd9-2aff902d7ce1)
![image](https://github.com/user-attachments/assets/8de312b4-7965-4675-a6b3-2dcd75f368c4)


* **Interface Web Completa:** Uma interface web intuitiva com listagem paginada, funcionalidade de busca e formulários para todas as operações CRUD, com validações tanto no frontend quanto no backend.
* Listagem:
* ![image](https://github.com/user-attachments/assets/8b6a4abf-5be5-44d0-8d64-40c96b6dfa10)
* Paginação:
* ![image](https://github.com/user-attachments/assets/4a728c42-201c-4522-bf4e-060d7669c9a9)

* Filtros:
* ![image](https://github.com/user-attachments/assets/92045f89-3e45-4d0b-9932-ce3f51b0e66c)

* Criação:
* ![image](https://github.com/user-attachments/assets/6d3a48b2-c5fa-4d96-950c-3ce8d710a4af)
* Edição:
* ![image](https://github.com/user-attachments/assets/fe562fb0-e8c2-4126-b7d0-943047aabcd1)

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

Para executar os testes da aplicação, acesse o container e utilize o seguinte comando no seu terminal, dentro do diretório raiz do projeto:

```bash
php artisan test tests/Unit
