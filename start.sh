#!/bin/bash

echo "🚀 Iniciando Task Manager API..."

# Verificar se o Docker está rodando
if ! docker info > /dev/null 2>&1; then
    echo "❌ Docker não está rodando. Por favor, inicie o Docker Desktop."
    exit 1
fi

# Parar containers existentes
echo "🛑 Parando containers existentes..."
docker-compose down

# Construir e iniciar containers
echo "🔨 Construindo e iniciando containers..."
docker-compose up -d --build

# Aguardar os serviços ficarem prontos
echo "⏳ Aguardando serviços ficarem prontos..."
sleep 30

# Executar migrations
echo "📊 Executando migrations..."
docker-compose exec -T app php artisan migrate --force

echo "✅ Task Manager API está rodando!"
echo ""
echo "🌐 Acesse:"
echo "   - API: http://localhost:8000"
echo "   - phpMyAdmin: http://localhost:8080 (root/secret)"
echo "   - Mongo Express: http://localhost:8081 (admin/admin)"
echo ""
echo "📚 Endpoints disponíveis:"
echo "   - POST /api/tasks - Criar tarefa"
echo "   - GET /api/tasks - Listar tarefas"
echo "   - GET /api/tasks/{id} - Visualizar tarefa"
echo "   - PUT /api/tasks/{id} - Atualizar tarefa"
echo "   - DELETE /api/tasks/{id} - Excluir tarefa"
echo "   - GET /api/logs - Listar logs"
echo ""
echo "Para parar os serviços: docker-compose down"
