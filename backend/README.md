# Backend Laravel para Sistema de Gestão do Salão de Beleza

Este diretório contém uma implementação de referência para a API do sistema usando **Laravel 11** e **Laravel Sanctum**. O código foi organizado de forma que possa ser copiado para uma aplicação criada com `laravel/laravel`. Como o ambiente deste repositório não possui acesso à rede para baixar dependências, execute os passos abaixo localmente para obter uma instância funcional.

## ✅ Preparação do Projeto

1. Crie um novo projeto Laravel:
   ```bash
   composer create-project laravel/laravel backend
   ```
2. Copie o conteúdo deste diretório sobre o projeto recém-criado (substituindo os arquivos existentes quando indicado).
3. Instale as dependências adicionais:
   ```bash
   cd backend
   composer require laravel/sanctum
   ```
4. Execute as migrações e seeders:
   ```bash
   php artisan migrate --seed
   ```
5. Inicie o servidor de desenvolvimento:
   ```bash
   php artisan serve
   ```

## 🔐 Autenticação

- A API utiliza **Laravel Sanctum** para autenticação baseada em tokens.
- Use a rota `POST /api/auth/login` para obter um token. Cada requisição autenticada deve enviar o header `Authorization: Bearer <token>`.

## 👥 Perfis e Regras de Acesso

A aplicação implementa RBAC simples baseado no campo `role` da tabela `users`.

| Papel          | Descrição | Principais Permissões |
|----------------|-----------|------------------------|
| `admin`        | Controle completo do sistema | Gerenciar usuários, serviços, itens, preços, agendamentos |
| `manager`      | Gestão operacional | Gerenciar serviços, itens, preços e agendamentos |
| `professional` | Profissionais do salão | Visualizar e atualizar seus agendamentos |
| `receptionist` | Recepção | Criar e atualizar agendamentos |

Use o middleware `role` definido em `App\Http\Middleware\EnsureUserHasRole` para proteger rotas.

## 📚 Estrutura

- `app/Enums` – enums usados pelos modelos (`Role`, `AppointmentStatus`).
- `app/Http/Controllers` – controladores RESTful para cada recurso.
- `app/Http/Requests` – validações para criação/atualização.
- `app/Http/Resources` – camadas de apresentação (transformers JSON).
- `app/Models` – modelos Eloquent com relacionamentos.
- `database/migrations` – esquema relacional completo.
- `database/seeders` – dados iniciais (usuários, serviços, itens, preços).
- `routes/api.php` – definição de rotas com autenticação + RBAC.

## 🔗 Integração com o Front-end

Configure a variável `VITE_API_URL` no projeto React apontando para a URL base exposta pelo Laravel (`http://localhost:8000/api`, por exemplo). As chaves utilizadas no front-end (`users`, `services`, `items`, `appointments`, `item-prices`, `item-price-histories`) possuem endpoints correspondentes neste backend.

## 🧪 Testes de Referência

Incluímos testes de feature demonstrando o fluxo de autenticação e operações CRUD. Execute-os com:

```bash
php artisan test
```

## 🗃️ Estrutura das Tabelas

As principais tabelas são:

- `users` – inclui `role` (enum) e `password` (hash).
- `services` – catálogo de serviços com duração e preço base.
- `items` – controle de estoque.
- `item_prices` – lista de preços por item, com datas de vigência.
- `item_price_histories` – histórico de alterações de preço.
- `appointments` – agendamentos com status e associação a profissionais.

Cada alteração de preço gera automaticamente um registro em `item_price_histories`.

## 🔄 Fluxo de Autenticação Exemplo

1. `POST /api/auth/login` com `email` e `password`.
2. Receba token e dados do usuário logado.
3. Use `GET /api/me` para recuperar o perfil.
4. Encerre a sessão com `POST /api/auth/logout`.

---

> **Observação:** Este diretório não contém os arquivos `vendor/` do Laravel. Gere-os localmente com `composer install` após copiar os arquivos.
