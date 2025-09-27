@echo off
echo 🚀 Iniciando Task Manager API...

REM Verificar se o Docker está rodando
docker info >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Docker não está rodando. Por favor, inicie o Docker Desktop.
    pause
    exit /b 1
)

REM Parar containers existentes
echo 🛑 Parando containers existentes...
docker-compose down

REM Construir e iniciar containers
echo 🔨 Construindo e iniciando containers...
docker-compose up -d --build

REM Aguardar os serviços ficarem prontos
echo ⏳ Aguardando serviços ficarem prontos...
timeout /t 30 /nobreak >nul

REM Executar migrations
echo 📊 Executando migrations...
docker-compose exec -T app php artisan migrate --force

echo ✅ Task Manager API está rodando!
echo.
echo 🌐 Acesse:
echo    - API: http://localhost:8000
echo    - phpMyAdmin: http://localhost:8080 (root/secret)
echo    - Mongo Express: http://localhost:8081 (admin/admin)
echo.
echo 📚 Endpoints disponíveis:
echo    - POST /api/tasks - Criar tarefa
echo    - GET /api/tasks - Listar tarefas
echo    - GET /api/tasks/{id} - Visualizar tarefa
echo    - PUT /api/tasks/{id} - Atualizar tarefa
echo    - DELETE /api/tasks/{id} - Excluir tarefa
echo    - GET /api/logs - Listar logs
echo.
echo Para parar os serviços: docker-compose down
pause
