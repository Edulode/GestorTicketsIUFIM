@echo off
echo ===============================================
echo  CONFIGURACION INICIAL - GESTOR TICKETS IUFIM
echo ===============================================
echo.

echo Este script configurara el sistema para uso en red local
echo.
pause

REM Verificar si estamos en la carpeta correcta
if not exist "artisan" (
    echo ERROR: Este script debe ejecutarse desde la carpeta del proyecto Laravel
    pause
    exit /b 1
)

echo [1/8] Verificando requisitos del sistema...

REM Verificar PHP
php --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ERROR: PHP no encontrado en el sistema
    echo Instalar PHP 8.1 o superior desde: https://windows.php.net/download/
    pause
    exit /b 1
)
echo ✓ PHP encontrado

REM Verificar Composer
composer --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ERROR: Composer no encontrado
    echo Instalar desde: https://getcomposer.org/download/
    pause
    exit /b 1
)
echo ✓ Composer encontrado

REM Verificar Node.js
node --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ADVERTENCIA: Node.js no encontrado
    echo Para compilar assets, instalar desde: https://nodejs.org/
) else (
    echo ✓ Node.js encontrado
)

echo.
echo [2/8] Instalando dependencias de PHP...
composer install --optimize-autoloader
if %errorlevel% neq 0 (
    echo ERROR: Error al instalar dependencias de PHP
    pause
    exit /b 1
)

echo.
echo [3/8] Generando clave de aplicacion...
php artisan key:generate
if %errorlevel% neq 0 (
    echo ERROR: Error al generar clave de aplicacion
    pause
    exit /b 1
)

echo.
echo [4/8] Configurando base de datos...
echo.
echo Opciones de base de datos:
echo 1. SQLite (Recomendado - mas simple)
echo 2. MySQL (Requiere instalacion separada)
echo.
choice /c 12 /m "Seleccionar opcion"

if %errorlevel%==1 (
    echo Configurando SQLite...
    REM Crear archivo de base de datos SQLite
    if not exist "database" mkdir database
    echo. > database\database.sqlite
    
    REM Actualizar .env para SQLite
    powershell -Command "(gc .env) -replace 'DB_CONNECTION=mysql', 'DB_CONNECTION=sqlite' | Out-File -encoding ASCII .env.temp"
    powershell -Command "(gc .env.temp) -replace 'DB_HOST=.*', '# DB_HOST=127.0.0.1' | Out-File -encoding ASCII .env.temp2"
    powershell -Command "(gc .env.temp2) -replace 'DB_PORT=.*', '# DB_PORT=3306' | Out-File -encoding ASCII .env.temp3"
    powershell -Command "(gc .env.temp3) -replace 'DB_DATABASE=.*', 'DB_DATABASE=database/database.sqlite' | Out-File -encoding ASCII .env.temp4"
    powershell -Command "(gc .env.temp4) -replace 'DB_USERNAME=.*', '# DB_USERNAME=root' | Out-File -encoding ASCII .env.temp5"
    powershell -Command "(gc .env.temp5) -replace 'DB_PASSWORD=.*', '# DB_PASSWORD=' | Out-File -encoding ASCII .env"
    del .env.temp .env.temp2 .env.temp3 .env.temp4 .env.temp5
    echo ✓ Base de datos SQLite configurada
) else (
    echo Manteniendo configuracion MySQL existente
    echo IMPORTANTE: Asegurate de que MySQL este funcionando
    pause
)

echo.
echo [5/8] Ejecutando migraciones...
php artisan migrate
if %errorlevel% neq 0 (
    echo ERROR: Error al ejecutar migraciones
    echo Verificar configuracion de base de datos
    pause
    exit /b 1
)

echo.
echo [6/8] Cargando datos iniciales...
php artisan db:seed
if %errorlevel% neq 0 (
    echo ADVERTENCIA: Error al cargar datos iniciales
    echo El sistema funcionara pero sin datos de ejemplo
)

echo.
echo [7/8] Configurando IP para red local...
for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr "IPv4"') do (
    set IP=%%a
    goto :found
)
:found
set IP=%IP: =%

echo IP detectada: %IP%
powershell -Command "(gc .env) -replace 'APP_URL=.*', 'APP_URL=http://%IP%:8000' | Out-File -encoding ASCII .env"
echo ✓ URL configurada para red local

echo.
echo [8/8] Instalando dependencias de interfaz...
node --version >nul 2>&1
if %errorlevel% neq 0 (
    echo Saltando instalacion de Node.js (no encontrado)
) else (
    npm install
    npm run build
    echo ✓ Assets compilados
)

echo.
echo ===============================================
echo  CONFIGURACION COMPLETADA
echo ===============================================
echo.
echo El sistema esta listo para usar en red local
echo.
echo URL del sistema: http://%IP%:8000
echo.
echo Para iniciar el servidor, ejecutar:
echo   iniciar_servidor_red.bat
echo.
echo Para crear backups, ejecutar:
echo   crear_backup.bat
echo.
echo ===============================================
echo.

echo Creando usuario administrador...
echo.
set /p ADMIN_NAME="Nombre del administrador: "
set /p ADMIN_EMAIL="Email del administrador: "
set /p ADMIN_PASSWORD="Password del administrador: "

php artisan tinker --execute="$user = new App\Models\User(); $user->name = '%ADMIN_NAME%'; $user->email = '%ADMIN_EMAIL%'; $user->password = Hash::make('%ADMIN_PASSWORD%'); $user->save(); echo 'Usuario administrador creado exitosamente';"

echo.
echo ✓ Usuario administrador creado
echo   Email: %ADMIN_EMAIL%
echo   Password: [configurado]
echo.
echo ===============================================
echo ¿Desea iniciar el servidor ahora? (S/N)
choice /c SN /m "Seleccionar opcion"

if %errorlevel%==1 (
    echo.
    echo Iniciando servidor...
    call iniciar_servidor_red.bat
) else (
    echo.
    echo Para iniciar el servidor manualmente, ejecutar:
    echo   iniciar_servidor_red.bat
    echo.
    pause
)