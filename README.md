# PPW 2

Projeto desenvolvido para a disciplina de **Programação para Web 2**.

A aplicação utiliza **Laravel**, **PHP**, **Nginx** e **PostgreSQL**, sendo executada através de containers Docker.

## Tecnologias utilizadas

* Laravel
* PHP
* Nginx
* PostgreSQL
* Docker
* Docker Compose

## Pré-requisitos

Antes de executar o projeto, é necessário ter instalado:

* [Git](https://git-scm.com/)
* [Docker](https://www.docker.com/)

Não é necessário instalar PHP, Laravel, Nginx ou PostgreSQL diretamente na máquina, pois esses serviços são executados através do Docker.

## Como executar o projeto

### 1. Clonar o repositório

Abra um terminal e execute:

```bash
git clone https://github.com/Eduardo-Serafim-Oliv/ppw-2.git
```

Entre na pasta do projeto:

```bash
cd ppw-2
```

### 2. Iniciar os containers

Execute:

```bash
docker compose up --build -d
```

Esse comando irá:

* construir a imagem do PHP;
* baixar as imagens necessárias;
* criar os containers;
* criar a rede entre os serviços;
* iniciar o Nginx;
* iniciar o Laravel;
* iniciar o PostgreSQL.

### 3. Acessar a aplicação

Após os containers serem iniciados, acesse:

```text
http://localhost:8080
```

### 4. Verificar os containers

Para verificar se os serviços estão em execução:

```bash
docker compose ps
```

Os principais serviços são:

| Serviço    | Função                        | Porta   |
| ---------- | ----------------------------- | ------- |
| `nginx`    | Servidor web                  | `8080`  |
| `php`      | Execução da aplicação Laravel | Interna |
| `postgres` | Banco de dados PostgreSQL     | `5433`  |

## Acesso ao banco de dados

O PostgreSQL utiliza a porta `5433` na máquina do usuário.

Para conectar utilizando uma ferramenta como DBeaver ou pgAdmin:

```text
Host: localhost
Porta: 5433
Banco de dados: laravel
Usuário: laravel
Senha: secret
```

### Importante

A aplicação Laravel não utiliza `localhost:5433` para acessar o banco.

Como Laravel e PostgreSQL estão em containers na mesma rede Docker, a aplicação utiliza:

```text
Host: postgres
Porta: 5432
```

A porta `5433` é utilizada somente para permitir o acesso ao PostgreSQL a partir da máquina hospedeira.

## Comandos úteis

### Iniciar os containers

```bash
docker compose up -d
```

### Iniciar reconstruindo as imagens

```bash
docker compose up --build -d
```

### Parar os containers

```bash
docker compose down
```

### Visualizar os containers

```bash
docker compose ps
```

### Visualizar os logs

```bash
docker compose logs
```

Para visualizar os logs de um serviço específico:

```bash
docker compose logs nginx
```

ou:

```bash
docker compose logs php
```

### Acessar o terminal do container PHP

```bash
docker compose exec php bash
```

### Executar comandos Artisan

Os comandos Artisan podem ser executados dentro do container PHP. Por exemplo:

```bash
docker compose exec php php artisan migrate
```

## Portas utilizadas

| Aplicação  | Porta no computador | Porta no container |
| ---------- | ------------------: | -----------------: |
| Nginx      |              `8080` |               `80` |
| PostgreSQL |              `5433` |             `5432` |

Portanto:

* Aplicação: **http://localhost:8080**
* PostgreSQL: **localhost:5433**

## Encerrando o projeto

Para parar e remover os containers:

```bash
docker compose down
```

Os dados persistentes do PostgreSQL são armazenados em um volume Docker, portanto a remoção dos containers não implica necessariamente na remoção dos dados do banco.

Para remover também os volumes:

```bash
docker compose down -v
```

> **Atenção:** o comando acima remove os volumes associados ao projeto e pode apagar os dados persistidos do banco de dados.
