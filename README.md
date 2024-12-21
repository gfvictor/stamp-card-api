# **Projeto de Digitalização de Programa de Fidelidade (Cartão de Pontos)**

### Índice:

- [Descrição do Projeto](#descrição-do-projeto)
- [Como Executar o Projeto](#como-executar-o-projeto)
- [Estrutura do Banco de Dados](#estrutura-do-banco-de-dados)
- [Endpoints da API](#endpoints-da-api)
  - [Clientes](#clientes)
  - [Lojas](#lojas)
  - [Regras](#regras)
  - [Transações](#transações)
  - [Pontos](#pontos)
- [Próximos Passos](#próximos-passos)

---

## Descrição do Projeto:

- Sistema de gerenciamento de pontos de fidelidade, permitindo que clientes acumulem pontos com base em suas compras 
em lojas específicas. A lógica de pontos é baseada em regras personalizadas por loja, e distribuída pela aplicação.

---

### Tecnologias Utilizadas:

- **Laravel 11.x** - Framework PHP para o backend.
- **MySQL** - Banco de dados relacional.
- **Composer** - Gerenciamento de dependências.
- **Postman** - Testes de API.

### Funcionalidades Principais:

- **Clientes**: Cadastro, consulta e gerenciamento.
- **Lojas**: Regras personalizadas para cálculo de pontos.
- **Regras**: Definição de quantidade de pontos por valor gasto por cliente em cada loja específica.
- **Transações**: Acúmulo ou resgate de pontos com base em compras realizadas.
- **Pontos**: Consulta total de pontos acumulados por clientes e envio de notificações para clientes e lojas.

---

## Como Executar o Projeto:

*Certifique-se de que o PHP, Composer e MySQL estejam configurados corretamente.*

- Clone o repositório:
```bash
git clone https://github.com/gfvictor/stamp-card-api.git
```

- Entre no diretório do projeto:
```bash
cd stamp-card-api 
```

- Instale as dependências:
```bash
composer install 
  ```

- Crie o arquivo .env copiando o exemplo fornecido:
```bash
cp .env.example .env
```

- Edite o arquivo .env para configurar as suas credenciais do banco de dados:
```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=stamp_card_api
DB_USERNAME=seu_usuário
DB_PASSWORD=sua_senha
```

- Gere a chave para a aplicação:
  - *Isso atualizará automaticamente o campo APP_KEY no .env*
```bash
php artisan key:generate
```

- Execute as migrações:
```bash
php artisan migrate
```

- Inicie o servidor:
```bash
php artisan serve 
```

- O projeto estará disponível no endereço: http://localhost:8000
- Teste os endpoints, listados abaixo da estrutura de banco de dados, usando o Postman ou Insomnia.


- [Voltar para o Índice](#índice)

---

## **Estrutura do Banco de Dados**:

- Tabela ***clients***:

| Campo        | Tipo      | Descrição                          |
|--------------|-----------|------------------------------------|
| id           | bigint    | Identificador único.               |
| name         | string    | Nome do cliente.                   |
| email        | string    | Email único do cliente.            |
| password     | string    | Senha do cliente (min: 8 dígitos). |
| phone_number | string    | Número de telefone do cliente.     |
| created_at   | timestamp | Data de criação.                   |
| updated_at   | timestamp | Data de atualização.               |


- Tabela ***stores***:

| Campo       | Tipo      | Descrição                       |
|-------------|-----------|---------------------------------|
| id          | bigint    | Identificador único.            |
| name        | string    | Nome da loja.                   |
| email       | string    | Email único da loja.            |
| password    | string    | Senha da loja (min: 8 dígitos). |
| address     | string    | Endereço da loja.               |
| created_at  | timestamp | Data de criação.                |
| updated_ at | timestamp | Data de atualização.            |

- Tabela ***rules***:

| Campo                | Tipo      | Descrição                                         |
|----------------------|-----------|---------------------------------------------------|
| id                   | bigint    | Identificador único.                              |
| stores_id            | bigint    | FK para a loja.                                   |
| yen_per_point        | integer   | Define quantos ienes gera 1 ponto.                |
| discount_amount      | integer   | Define valor do desconto para resgate.            |
| discount_type        | enum      | Define tipo de desconto ("cash" ou "percentage"). |
| expiration_in_months | integer   | Validade dos pontos (1 = Janeiro, etc.).          |
| created_at           | timestamp | Data de criação.                                  |
| updated_at           | timestamp | Data de atualização.                              |

- Tabela ***transactions***:

| Campo         | Tipo      | Descrição                                     |
|---------------|-----------|-----------------------------------------------|
| id            | bigint    | Identificador único.                          |
| clients_id    | bigint    | FK para o cliente.                            |
| stores_id     | bigint    | FK para a loja.                               |
| amount_spent  | integer   | Valor da transação.                           |
 | point_changes | integer   | Quantidade de pontos gerados ou resgatados.   |
| type          | enum      | Tipo de transação ("accumulate" ou "redeem"). |
| reason        | string    | Descrição da transação                        |
| created_at    | timestamp | Data de criação                               |

- Tabela ***points***:

| Campo           | Tipo      | Descrição                     |
|-----------------|-----------|-------------------------------|
| id              | bigint    | Identificador único.          |
| clients_id      | bigint    | FK para o cliente.            |
| stores_id       | bigint    | FK para a loja.               |
| transactions_id | bigint    | FK para a transação.          |
| points          | integer   | quantidade de pontos somados. |
| created_at      | timestamp | Data de criação.              |


- [Voltar para o Índice](#índice)

---

## Endpoints da API:

### Clientes:

- Criar cliente:
  - `POST /api/clients`
    - Body:
```json
{
  "name": "Cliente",
  "email": "cliente@email.com",
  "password": "senha123",
  "phone_number": "08012345678"
}
```
-
  - 
     - Resposta:
```json
{
  "id": 1,
  "name": "Cliente",
  "email": "cliente@email.com",
  "password": "senha123",
  "phone_number": "08012345678",
  "created_at": "2024-12-16T12:00:00Z"
}
```
- Listar todos os clientes:
  - `GET /api/clients`

- Listar cliente por id:
  - `GET /api/clients/{id}`

- Editar cliente:
  - `PUT /api/clients/{id}`
    - Body:
```json
{
  "password": "senha456"
}
```
-
  - 
     - Resposta:
```json
{
  "id": 1,
  "name": "Cliente",
  "email": "cliente@email.com",
  "phone_number": "08012345678",
  "created_at": "2024-12-16T12:00:00Z",
  "updated_at": "2024-12-16T14:23:54Z"
}
```

- Excluir cliente:
  - `DELETE /api/clients/{id}`
    - Resposta:
```json
{
  "message": "Cliente deletado com sucesso."
}
```

- Gerar QR Code:
  - `GET /api/clients/{id}/qr-code`
    - Body:
```json
{
  "qr-code": "<base64_encoded_qr_code>"
}
```

### Lojas:

- Criar loja:
  - `POST /api/stores`
    - Body:
```json
{
  "name": "Loja",
  "email": "loja@email.com",
  "password": "senha123",
  "address": "Nome da Rua, Número, Cidade, Província"
}
```
-
  -
    - Resposta:
```json
{
  "id": 1,
  "name": "Loja",
  "email": "loja@email.com",
  "password": "senha123",
  "address": "Nome da Rua, Número, Cidade, Província",
  "created_at": "2024-12-16T12:00:00Z"
}
```

- Listar todas as lojas:
  - `GET /api/stores`

- Listar loja por id:
  - `GET /api/stores/{id}`

- Editar loja:
  - `PUT /api/stores/{id}`
    - Body:
```json
{
  "name": "Loja Renovada"
}
```
-
  -
    - Resposta:
```json
{
  "id": 1,
  "name": "Loja Renovada",
  "email": "loja@email.com",
  "address": "Nome da Rua, Número, Cidade, Província",
  "created_at": "2024-12-16T12:00:00Z",
  "updated_at": "2024-12-17T07:21:33Z"
}
```

- Excluir loja:
  - `DELETE /api/stores/{id}`
    - Resposta:
```json
{
  "message": "Loja deletada com sucesso."
}
```

### Regras:

- Criar regra para loja:
  - `POST /api/rules`
    - Body:
```json
{
  "stores_id": 1,
  "yen_per_point": 200
}
```
-
  -
    - Resposta:
```json
{
  "stores_id": 1,
  "yen_per_point": 200,
  "discount_amount": 0,
  "discount_type": null,
  "expiration_in_months": null,
  "created_at": "2024-12-16T12:00:00Z"
}
```
- Listar todas as regras:
  - `GET /api/rules`

- Listar regra por id:
  - `GET /api/rules/{id}`

- Listar regra por loja:
  - `GET /api/rules/store/{stores_id}`

- Editar regra:
  - `PUT /api/rules/{id}`
    - Body:
```json
{
  "yen_per_point": 400
}
```

- 
  -
    - Resposta:
```json
{
  "stores_id": 1,
  "yen_per_point": 400,
  "discount_amount": 0,
  "discount_type": null,
  "expiration_in_months": null,
  "created_at": "2024-12-16T12:00:00Z",
  "updated_At": "2024-12-17T04:11:41Z"
}
```

- Excluir regra:
  - `DELETE /api/rules/{id}`
    - Resposta:
```json
{
  "message": "Regra deletada com sucesso."
}
```

### Transações:

- Gerar pontos para cliente via QR Code:
  - `POST /api/transactions/grant-points`
    - Body:
```json
{
  "qr_code_data": "{\"clients_id\":1\"phone_number\":\"08012345678\"}",
  "stores_id": 1,
  "amount_spent": 4760
}
```

-
  -
    - Resposta:
```json
{
  "id": 1,
  "clients_id": 1,
  "stores_id": 1,
  "amount_spent": 4760,
  "point_changes": 23,
  "type": "accumulate",
  "reason": "Pontos creditados via QR Code!",
  "created_at": "2024-12-16T12:00:00Z"
}
```

- Listar todas as transações:
  - `GET /api/transactions`

- Listar transação por id:
  - `GET /api/transactions/{id}`

## Pontos:

- Listar todos os pontos:
  - `GET /api/points`

- Listar pontos por id:
  - `GET /api/points/{id}`

- Excluir pontos:
  - `DELETE /api/points/{id}`
    - Resposta:
```json
{
  "message": "Pontos deletados com sucesso."
}
```
- [Voltar para o Índice](#índice)

---

## Próximos Passos:

1. **Finalizar a criação de Actions:**
   - Criar Actions para Rules e Points.


2. **Verificação de Pontos:**
    - Confirmar se a lógica de soma de pontos está correta.
    - Corrigir o endpoint /points/total (talvez redundante).
    - Restringir o acesso à edição e exclusão de pontos para apenas o admin.


3. **Endpoints para Admin:**
    - Criar lógica e endpoints para admins.
    - configurar autenticação.


4. **Autenticação:**
    - Implementar autenticação com tokens JWT (ou somente sanctum) para proteger os endpoints da API.
    - permitir que apenas usuários autenticados acessem as rotas.
    - Definir quais elementos terão acesso às quais rotas.
    - Definir acesso para Admins.


5. **Teste Automatizado:**
    - Criar testes unitários e de integração para validar a lógica dos pontos e das transações.


6. **Relatórios:**
    - Implementar lógica e endpoints para gerar relatórios detalhados:
      - Total de pontos acumulados por loja.
      - Histórico completo de transações de cada cliente.
      - Histórico de resgate de pontos semanais ou mensais para fechamento de caixa das lojas.


- [Voltar para o Índice](#índice)

---