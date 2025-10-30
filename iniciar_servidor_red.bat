@echo off
echo ===============================================
echo  GESTOR DE TICKETS IUFIM - CONFIGURACION RED
echo ===============================================
echo.

REM Obtener IP actual
for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr "IPv4"') do (
    set IP=%%a
    goto :found
)
:found
set IP=%IP: =%

echo IP del servidor detectada: %IP%
echo.
echo ===============================================
echo  INICIANDO SERVIDOR EN RED LOCAL
echo ===============================================
echo.
echo El sistema estara disponible en:
echo http://%IP%:8000
echo.
echo Desde otros equipos usar la misma URL
echo Presiona Ctrl+C para detener el servidor
echo.
echo ===============================================
echo.

REM Cambiar al directorio del proyecto
cd /d "%~dp0"

REM Verificar si composer esta instalado
composer --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ERROR: Composer no encontrado
    echo Instalar desde: https://getcomposer.org/download/
    pause
    exit /b 1
)

REM Verificar si las dependencias estan instaladas
if not exist "vendor" (
    echo Instalando dependencias de PHP...
    composer install --optimize-autoloader
)

REM Verificar si la base de datos esta configurada
php artisan migrate:status >nul 2>&1
if %errorlevel% neq 0 (
    echo Configurando base de datos...
    php artisan migrate
    php artisan db:seed
)

REM Limpiar cache
echo Optimizando aplicacion...
php artisan config:clear
php artisan cache:clear
php artisan view:clear

REM Verificar si los assets estan compilados
if not exist "public\build" (
    echo Compilando assets de interfaz...
    call npm install
    call npm run build
)

REM Iniciar servidor
echo.
echo Servidor iniciando...
echo.
php artisan serve --host=0.0.0.0 --port=8000