  # **Teste para Desenvolvedor: API de Cadastro de Clientes com Validação de CEP**

O objetivo deste teste é desenvolver uma **API Rest** para o cadastro de clientes, garantindo que o cliente esteja em um CEP valido.

---

## **Descrição do Projeto**

#### O projeto é um backend (API Laravel) que realiza o CRUD de clientes com informações básicas.

#### **Cadastro de Clientes**
- Criar um cliente com as seguintes informações:
  - Nome completo
  - CPF (validado, único no banco)
  - E-mail (validado, único no banco)
  - Telefone
  - CEP 
  - Endereço (logradouro, bairro, cidade, estado)

- Editar um cliente
- Excluir um cliente
- Listar clientes (paginação, filtro por nome, CPF e CEP)

---

## **Tecnologias a serem utilizadas**
- **PHP 8.x**
- **Laravel 10.x**
- **Banco de Dados**: MySQL ou PostgreSQL

---

## **Como rodar esse projeto**
- Este projeto é uma API Laravel dockerizada, pronta para ser clonada e executada facilmente usando Docker e Docker compose.
- Como é uma API para testes, ao rodar as migrations e as seeds será criado apenas um usuário que poderaá gerar um token para acesso dos endpoints.
---

## Pré-requisitos

* Git instalado
* Docker e Docker Compose instalados no seu sistema

---

## Como rodar o projeto

1. Clone o repositório:

   ```bash
   git clone <URL_DO_REPOSITORIO>
   cd <NOME_DA_PASTA_CLONADA>/dev_test
   ```

2. Crie o **.env** copiando o **.env.example** que já está configurado, uma vez que essa é uma api para testes.


#### Configurações adicionais

Verifique se o arquivo `.env` está configurado corretamente para conexão com o banco de dados, especialmente estas variáveis:

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=dev_test
DB_USERNAME=dev_user
DB_PASSWORD=dev_password
```

Os containers já criam uma rede chamada `laravel-network` e um volume para persistência do banco.

---

3. Suba os containers Docker, buildando a imagem:

   ```bash
   sudo docker-compose up -d --build
   ```

#### Rodando Migrations

```bash
sudo docker exec -it laravel-app php artisan migrate
```

---

4. Execute o seeder para popular a base com o usuário para o acesso de endpoints:

   ```bash
   sudo docker exec -it laravel-app php artisan db:seed --class=UserSeeder
   ```

5. A API estará disponível em:

   ```
   http://localhost:8000
   ```

---

## Rotas disponíveis

### Login

* **Endpoint:** `POST /api/login`

* **Payload exemplo (User criado ao rodar a seed):**

  ```json
    {
        "email": "teste_dev@teste.com",
        "password": "senhadev"
    }
  ```
  * **Resposta (sucesso):**

  ```json
    {
        "access_token": "<TOKEN GERADO>",
        "token_type": "Bearer"
    }
  ```

## Todas as demais rotas necessitam do BearerToken na autenticação.

### 1. Criar cliente

* **Endpoint:** `POST /api/customers`

* **Payload exemplo:**

  ```json
    {
        "name": "Dev Testando",
        "cpf": "08289997086",
        "email": "dev_testando@teste.com",
        "phone": "11999999999",
        "cep": "79062567",
        "street": "Rua Exemplo",
        "neighborhood": "Centro",
        "city": "São Paulo",
        "state": "SP"
    }

  ```

* **Resposta (sucesso):**

  ```json
    {
        "name": "Dev Testando",
        "email": "dev_testando@teste.com",
        "cpf": "08289997086",
        "phone": "11999999999",
        "cep": "79062567",
        "street": "Rua Exemplo",
        "neighborhood": "Centro",
        "city": "São Paulo",
        "state": "SP",
        "updated_at": "2025-07-20T16:17:14.000000Z",
        "created_at": "2025-07-20T16:17:14.000000Z",
        "id": 1
    }
    ```

---

### 2. Listar clientes

* **Endpoint:** `GET /api/customers`
- É possível realizar buscas filtradas pelos seguintes campos:
    - name (nome do cliente)
    - cpf
    - cep
- Exemplo de uso:
    - GET /api/customers?name=devTest
    - GET /api/customers?cpf=12312312312
    - GET /api/customers?cep=12345678
* **Resposta (sucesso):**

  ```json
    {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "name": "Dev Testando",
                "cpf": "08289997086",
                "email": "dev_testando@teste.com",
                "phone": "11999999999",
                "cep": "79062567",
                "street": "Rua Exemplo",
                "neighborhood": "Centro",
                "city": "São Paulo",
                "state": "SP",
                "created_at": "2025-07-20T16:17:14.000000Z",
                "updated_at": "2025-07-20T16:17:14.000000Z"
            }
        ],
        "first_page_url": "http://localhost:8000/api/customer?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://localhost:8000/api/customer?page=1",
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://localhost:8000/api/customer?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "next_page_url": null,
        "path": "http://localhost:8000/api/customer",
        "per_page": 15,
        "prev_page_url": null,
        "to": 1,
        "total": 1
    }
    ```

---

### 3. Atualizar cliente

* **Endpoint:** `PUT /api/customers/{id}`

* **Payload exemplo:**

  ```json
    {
        "name": "Dev Testando 2",
        "cpf": "08289997086",
        "email": "dev_testando2@teste.com",
        "phone": "11999999999",
        "cep": "03203040",
        "street": "Rua Exemplo",
        "neighborhood": "Centro",
        "city": "São Paulo",
        "state": "mg"
    }
  ```

* **Resposta (sucesso):**

  ```json
    {
        "id": 1,
        "name": "Dev Testando 2",
        "cpf": "08289997086",
        "email": "dev_testando2@teste.com",
        "phone": "11999999999",
        "cep": "03203040",
        "street": "Rua Exemplo",
        "neighborhood": "Centro",
        "city": "São Paulo",
        "state": "MG",
        "created_at": "2025-07-20T16:17:14.000000Z",
        "updated_at": "2025-07-20T16:24:53.000000Z"
    }
  ```

---

### 4. Deletar cliente

* **Endpoint:** `DELETE /api/customers/{id}`

* **Resposta (sucesso):**
    - Status: 204 No content

---

## Comandos úteis

  ```bash
  sudo docker exec -it laravel-app php artisan <comando>
  ```

---
