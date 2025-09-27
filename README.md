# Task Manager API

Sistema de gerenciamento de tarefas desenvolvido com Laravel Lumen, utilizando MySQL para dados das tarefas e logs de eventos.

## 🚀 Tecnologias Utilizadas

-   **PHP 8.2+**
-   **Laravel Lumen v10+**
-   **MySQL** - Banco de dados relacional para tarefas e logs
-   **Docker** - Containerização da aplicação
-   **Swagger** - Documentação da API

## 📋 Funcionalidades

### Tarefas (Tasks)

-   ✅ Criar nova tarefa
-   ✅ Listar todas as tarefas
-   ✅ Filtrar tarefas por status (pendente, em progresso, concluída)
-   ✅ Visualizar tarefa específica
-   ✅ Atualizar tarefa
-   ✅ Excluir tarefa

### Logs de Eventos

-   ✅ Registro automático de todas as ações (criação, atualização, exclusão)
-   ✅ Listagem dos últimos 30 logs
-   ✅ Visualização de log específico por ID
-   ✅ Testes unitários automatizados

## 🛠️ Instalação e Execução

### Pré-requisitos

-   Docker e Docker Compose instalados
-   Git

### 1. Clone o repositório

```bash
git clone <repository-url>
cd task-manager
```

### 2. Execute com Docker Compose

```bash
docker-compose up -d
```

### 3. Execute as migrations

```bash
docker-compose exec app php artisan migrate
```

### 4. Acesse a aplicação

-   **API**: http://localhost:8000
-   **Documentação Swagger**: http://localhost:8000/api/documentation
-   **phpMyAdmin**: http://localhost:8080 (usuário: root, senha: secret)
-   **Mongo Express**: http://localhost:8081 (usuário: admin, senha: admin)

## 📚 Endpoints da API

### Tarefas

#### Criar Tarefa

```http
POST /api/tasks
Content-Type: application/json

{
    "title": "Nova tarefa",
    "description": "Descrição da tarefa",
    "status": "pending"
}
```

#### Listar Tarefas

```http
GET /api/tasks
GET /api/tasks?status=pending
```

#### Visualizar Tarefa

```http
GET /api/tasks/{id}
```

#### Atualizar Tarefa

```http
PUT /api/tasks/{id}
Content-Type: application/json

{
    "title": "Tarefa atualizada",
    "status": "in_progress"
}
```

#### Excluir Tarefa

```http
DELETE /api/tasks/{id}
```

### Logs

#### Listar Logs

```http
GET /api/logs
GET /api/logs?id={log_id}
```

## 🏗️ Arquitetura

### Princípios SOLID Aplicados

1. **Single Responsibility Principle (SRP)**

    - Cada controller tem uma responsabilidade específica
    - Models separados para Task e Log
    - Middleware dedicado para logging

2. **Open/Closed Principle (OCP)**

    - Controllers extensíveis através de herança
    - Middleware configurável

3. **Liskov Substitution Principle (LSP)**

    - Models seguem contratos do Eloquent
    - Controllers seguem padrões do Laravel

4. **Interface Segregation Principle (ISP)**

    - Interfaces específicas para cada funcionalidade
    - Separação clara entre responsabilidades

5. **Dependency Inversion Principle (DIP)**
    - Injeção de dependências através do container do Laravel
    - Abstrações para logging

### Estrutura do Projeto

```
task-manager/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── TaskController.php
│   │   │   ├── LogController.php
│   │   │   └── Controller.php
│   │   └── Middleware/
│   │       └── RequestLoggingMiddleware.php
│   └── Models/
│       ├── Task.php
│       └── Log.php
├── config/
│   ├── database.php
│   └── swagger-l5-swagger.php
├── database/
│   └── migrations/
├── routes/
│   └── web.php
├── Dockerfile
├── docker-compose.yml
└── README.md
```

## 🔧 Configuração

### Variáveis de Ambiente

O arquivo `.env` contém as configurações necessárias:

```env
# Aplicação
APP_NAME=TaskManager
APP_ENV=local
APP_DEBUG=true

# MySQL
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=

# MongoDB
MONGODB_CONNECTION=mongodb
MONGODB_HOST=127.0.0.1
MONGODB_PORT=27017
MONGODB_DATABASE=task_manager_logs
```

## 📊 Banco de Dados

### MySQL (Tarefas)

-   **Tabela**: `tasks`
-   **Campos**: id, title, description, status, created_at, updated_at
-   **Status**: pending, in_progress, completed

### MySQL (Logs)

-   **Tabela**: `logs`
-   **Campos**: id, action, entity_type, entity_id, details, ip_address, user_agent, created_at, updated_at

## 🧪 Testes

### Executar Testes

```bash
# Executar todos os testes
docker-compose exec app php artisan test

# Executar testes com cobertura
docker-compose exec app php artisan test --coverage

# Executar testes específicos
docker-compose exec app php artisan test --filter TaskTest
docker-compose exec app php artisan test --filter LogTest
```

### Testes Disponíveis

-   **TaskTest**: Testa todas as operações CRUD de tarefas
-   **LogTest**: Testa o sistema de logging e consulta de logs
-   **Validação**: Testa validação de dados e tratamento de erros
-   **Integração**: Testa a integração entre tarefas e logs

## 📝 Logs

Todos os eventos são automaticamente registrados no MySQL:

-   Criação de tarefas
-   Atualização de tarefas
-   Exclusão de tarefas
-   Visualização de tarefas
-   Requisições da API

## 🤝 Contribuição

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo `LICENSE` para mais detalhes.

## 👨‍💻 Autor: Renato Freitas

Desenvolvido como case prático para demonstração de habilidades em:

-   PHP 8.2+
-   Laravel Lumen
-   Arquitetura de software
-   Princípios SOLID
-   Docker
-   APIs RESTful
-   Documentação com Swagger
