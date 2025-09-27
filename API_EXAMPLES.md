# Exemplos de Uso da API

## 🚀 Como testar a API

### 1. Iniciar a aplicação

```bash
# Windows
start.bat

# Linux/Mac
./start.sh
```

### 2. Testar com cURL

#### Criar uma nova tarefa

```bash
curl -X POST http://localhost:8000/api/tasks \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Implementar autenticação",
    "description": "Adicionar sistema de login e registro de usuários",
    "status": "pending"
  }'
```

#### Listar todas as tarefas

```bash
curl -X GET http://localhost:8000/api/tasks
```

#### Filtrar tarefas por status

```bash
curl -X GET "http://localhost:8000/api/tasks?status=pending"
```

#### Visualizar uma tarefa específica

```bash
curl -X GET http://localhost:8000/api/tasks/1
```

#### Atualizar uma tarefa

```bash
curl -X PUT http://localhost:8000/api/tasks/1 \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Implementar autenticação - EM PROGRESSO",
    "status": "in_progress"
  }'
```

#### Excluir uma tarefa

```bash
curl -X DELETE http://localhost:8000/api/tasks/1
```

#### Listar logs de eventos

```bash
curl -X GET http://localhost:8000/api/logs
```

#### Visualizar um log específico

```bash
curl -X GET "http://localhost:8000/api/logs?id=507f1f77bcf86cd799439011"
```

### 3. Testar com Postman

Importe a coleção abaixo no Postman:

```json
{
    "info": {
        "name": "Task Manager API",
        "schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json"
    },
    "item": [
        {
            "name": "Criar Tarefa",
            "request": {
                "method": "POST",
                "header": [
                    {
                        "key": "Content-Type",
                        "value": "application/json"
                    }
                ],
                "body": {
                    "mode": "raw",
                    "raw": "{\n  \"title\": \"Nova tarefa\",\n  \"description\": \"Descrição da tarefa\",\n  \"status\": \"pending\"\n}"
                },
                "url": {
                    "raw": "http://localhost:8000/api/tasks",
                    "protocol": "http",
                    "host": ["localhost"],
                    "port": "8000",
                    "path": ["api", "tasks"]
                }
            }
        },
        {
            "name": "Listar Tarefas",
            "request": {
                "method": "GET",
                "url": {
                    "raw": "http://localhost:8000/api/tasks",
                    "protocol": "http",
                    "host": ["localhost"],
                    "port": "8000",
                    "path": ["api", "tasks"]
                }
            }
        },
        {
            "name": "Visualizar Tarefa",
            "request": {
                "method": "GET",
                "url": {
                    "raw": "http://localhost:8000/api/tasks/1",
                    "protocol": "http",
                    "host": ["localhost"],
                    "port": "8000",
                    "path": ["api", "tasks", "1"]
                }
            }
        },
        {
            "name": "Atualizar Tarefa",
            "request": {
                "method": "PUT",
                "header": [
                    {
                        "key": "Content-Type",
                        "value": "application/json"
                    }
                ],
                "body": {
                    "mode": "raw",
                    "raw": "{\n  \"title\": \"Tarefa atualizada\",\n  \"status\": \"in_progress\"\n}"
                },
                "url": {
                    "raw": "http://localhost:8000/api/tasks/1",
                    "protocol": "http",
                    "host": ["localhost"],
                    "port": "8000",
                    "path": ["api", "tasks", "1"]
                }
            }
        },
        {
            "name": "Excluir Tarefa",
            "request": {
                "method": "DELETE",
                "url": {
                    "raw": "http://localhost:8000/api/tasks/1",
                    "protocol": "http",
                    "host": ["localhost"],
                    "port": "8000",
                    "path": ["api", "tasks", "1"]
                }
            }
        },
        {
            "name": "Listar Logs",
            "request": {
                "method": "GET",
                "url": {
                    "raw": "http://localhost:8000/api/logs",
                    "protocol": "http",
                    "host": ["localhost"],
                    "port": "8000",
                    "path": ["api", "logs"]
                }
            }
        }
    ]
}
```

## 📊 Exemplos de Respostas

### Criar Tarefa (201)

```json
{
    "success": true,
    "data": {
        "id": 1,
        "title": "Implementar autenticação",
        "description": "Adicionar sistema de login e registro de usuários",
        "status": "pending",
        "created_at": "2025-09-27T16:30:00.000000Z",
        "updated_at": "2025-09-27T16:30:00.000000Z"
    },
    "message": "Tarefa criada com sucesso"
}
```

### Listar Tarefas (200)

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "title": "Implementar autenticação",
            "description": "Adicionar sistema de login e registro de usuários",
            "status": "pending",
            "created_at": "2025-09-27T16:30:00.000000Z",
            "updated_at": "2025-09-27T16:30:00.000000Z"
        }
    ],
    "message": "Tarefas listadas com sucesso"
}
```

### Erro de Validação (422)

```json
{
    "success": false,
    "message": "Dados de validação inválidos",
    "errors": {
        "title": ["O campo título é obrigatório."]
    }
}
```

### Tarefa Não Encontrada (404)

```json
{
    "success": false,
    "message": "Tarefa não encontrada"
}
```

### Log de Evento

```json
{
    "success": true,
    "data": [
        {
            "_id": "507f1f77bcf86cd799439011",
            "action": "created",
            "entity_type": "Task",
            "entity_id": 1,
            "details": {
                "title": "Implementar autenticação",
                "status": "pending"
            },
            "ip_address": "127.0.0.1",
            "user_agent": "curl/7.68.0",
            "created_at": "2025-09-27T16:30:00.000000Z",
            "updated_at": "2025-09-27T16:30:00.000000Z"
        }
    ],
    "message": "Logs listados com sucesso"
}
```

## 🔍 Monitoramento

### Verificar logs da aplicação

```bash
docker-compose logs -f app
```

### Verificar status dos containers

```bash
docker-compose ps
```

### Acessar banco de dados

-   **MySQL**: http://localhost:8080 (phpMyAdmin)
-   **MongoDB**: http://localhost:8081 (Mongo Express)

## 🧪 Testes Automatizados

### Executar testes

```bash
docker-compose exec app php artisan test
```

### Verificar cobertura de testes

```bash
docker-compose exec app php artisan test --coverage
```
