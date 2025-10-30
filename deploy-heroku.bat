@echo off
REM 🚀 Script de Deploy a Heroku - Windows
REM Gestor de Tickets IUFIM

echo ================================================
echo 🚀 DEPLOY A HEROKU - GESTOR TICKETS IUFIM
echo ================================================
echo.

REM Verificar si Heroku CLI está instalado
heroku --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Error: Heroku CLI no encontrado
    echo Instalar desde: https://devcenter.heroku.com/articles/heroku-cli
    pause
    exit /b 1
)

REM Verificar si Git está inicializado
if not exist ".git" (
    echo 📝 Inicializando repositorio Git...
    git init
)

REM Verificar login en Heroku
echo 🔐 Verificando login en Heroku...
heroku auth:whoami >nul 2>&1
if %errorlevel% neq 0 (
    echo 🔑 Iniciando sesión en Heroku...
    heroku login
)

REM Solicitar nombre de la aplicación
set /p APP_NAME="📝 Nombre de la aplicación Heroku (ej: gestor-tickets-iufim): "
if "%APP_NAME%"=="" (
    echo ❌ Error: Nombre de aplicación requerido
    pause
    exit /b 1
)

echo.
echo 🏗️ Configurando aplicación para Heroku...

REM Crear Procfile si no existe
if not exist "Procfile" (
    echo web: vendor/bin/heroku-php-apache2 public/ > Procfile
    echo ✅ Procfile creado
)

REM Crear runtime.txt si no existe
if not exist "runtime.txt" (
    echo php-8.2.0 > runtime.txt
    echo ✅ runtime.txt creado
)

REM Verificar si la aplicación ya existe
heroku apps:info %APP_NAME% >nul 2>&1
if %errorlevel% neq 0 (
    echo 🆕 Creando nueva aplicación: %APP_NAME%
    heroku create %APP_NAME%
    if %errorlevel% neq 0 (
        echo ❌ Error al crear aplicación
        pause
        exit /b 1
    )
) else (
    echo ✅ Aplicación %APP_NAME% ya existe
)

REM Conectar repositorio local con Heroku
echo 🔗 Conectando repositorio...
heroku git:remote -a %APP_NAME%

REM Configurar addon de base de datos
echo 🗄️ Configurando base de datos...
heroku addons:create jawsdb:kitefin -a %APP_NAME% 2>nul
if %errorlevel% neq 0 (
    echo ⚠️ Addon de base de datos ya existe o error al crear
)

REM Obtener URL de base de datos
for /f "tokens=*" %%i in ('heroku config:get JAWSDB_URL -a %APP_NAME%') do set JAWSDB_URL=%%i

REM Configurar variables de entorno
echo ⚙️ Configurando variables de entorno...

heroku config:set APP_NAME="Gestor Tickets IUFIM" -a %APP_NAME%
heroku config:set APP_ENV=production -a %APP_NAME%
heroku config:set APP_DEBUG=false -a %APP_NAME%
heroku config:set APP_URL=https://%APP_NAME%.herokuapp.com -a %APP_NAME%

REM Generar y configurar APP_KEY
echo 🔑 Generando clave de aplicación...
for /f "tokens=*" %%i in ('php artisan key:generate --show') do set APP_KEY=%%i
heroku config:set APP_KEY=%APP_KEY% -a %APP_NAME%

REM Configurar cache y sesiones
heroku config:set CACHE_DRIVER=database -a %APP_NAME%
heroku config:set SESSION_DRIVER=database -a %APP_NAME%
heroku config:set QUEUE_CONNECTION=database -a %APP_NAME%

REM Configurar email básico
set /p EMAIL_USER="📧 Email para notificaciones (opcional, Enter para saltar): "
if not "%EMAIL_USER%"=="" (
    set /p EMAIL_PASS="🔐 Contraseña de aplicación del email: "
    heroku config:set MAIL_MAILER=smtp -a %APP_NAME%
    heroku config:set MAIL_HOST=smtp.gmail.com -a %APP_NAME%
    heroku config:set MAIL_PORT=587 -a %APP_NAME%
    heroku config:set MAIL_USERNAME=%EMAIL_USER% -a %APP_NAME%
    heroku config:set MAIL_PASSWORD=%EMAIL_PASS% -a %APP_NAME%
    heroku config:set MAIL_ENCRYPTION=tls -a %APP_NAME%
    heroku config:set MAIL_FROM_ADDRESS=tickets@%APP_NAME%.herokuapp.com -a %APP_NAME%
    heroku config:set MAIL_FROM_NAME="Gestor Tickets IUFIM" -a %APP_NAME%
)

REM Preparar archivos para deploy
echo 📦 Preparando archivos...

REM Asegurar que no hay archivos innecesarios en .gitignore
findstr /V "public/build" .gitignore > .gitignore.tmp 2>nul
move .gitignore.tmp .gitignore 2>nul

REM Compilar assets si Node.js está disponible
npm --version >nul 2>&1
if %errorlevel% equ 0 (
    echo 🎨 Compilando assets...
    call npm install
    call npm run build
) else (
    echo ⚠️ Node.js no encontrado, saltando compilación de assets
)

REM Commit y deploy
echo 📤 Realizando deploy...
git add .
git commit -m "Deploy to Heroku - %date% %time%" 2>nul

echo 🚀 Subiendo a Heroku...
git push heroku main
if %errorlevel% neq 0 (
    echo ❌ Error durante el deploy
    pause
    exit /b 1
)

REM Ejecutar migraciones y seeders
echo 🗄️ Configurando base de datos en Heroku...
heroku run php artisan migrate --force -a %APP_NAME%
if %errorlevel% neq 0 (
    echo ⚠️ Error en migraciones, pero continuando...
)

heroku run php artisan db:seed --force -a %APP_NAME%
if %errorlevel% neq 0 (
    echo ⚠️ Error en seeders, pero continuando...
)

REM Crear usuario administrador
echo 👤 Creando usuario administrador...
set /p ADMIN_NAME="👤 Nombre del administrador: "
set /p ADMIN_EMAIL="📧 Email del administrador: "
set /p ADMIN_PASS="🔐 Contraseña del administrador: "

heroku run php artisan tinker --execute="$user = new App\Models\User(); $user->name = '%ADMIN_NAME%'; $user->email = '%ADMIN_EMAIL%'; $user->password = Hash::make('%ADMIN_PASS%'); $user->save(); echo 'Usuario administrador creado';" -a %APP_NAME%

echo.
echo ================================================
echo 🎉 DEPLOY COMPLETADO EXITOSAMENTE
echo ================================================
echo.
echo 🌐 URL de la aplicación: https://%APP_NAME%.herokuapp.com
echo 👤 Usuario administrador: %ADMIN_EMAIL%
echo 🔐 Contraseña: [la que configuraste]
echo.
echo 📋 Próximos pasos:
echo 1. Abrir https://%APP_NAME%.herokuapp.com
echo 2. Iniciar sesión con las credenciales del administrador
echo 3. Configurar categorías y tipos de solicitud
echo 4. Crear usuarios adicionales si es necesario
echo.
echo 🔧 Comandos útiles:
echo heroku logs --tail -a %APP_NAME%          (ver logs)
echo heroku config -a %APP_NAME%               (ver variables)
echo heroku run php artisan tinker -a %APP_NAME%  (consola)
echo.

REM Abrir aplicación en navegador
set /p OPEN_APP="¿Abrir aplicación en navegador? (S/N): "
if /i "%OPEN_APP%"=="S" (
    heroku open -a %APP_NAME%
)

echo.
echo ✅ Deploy completado. Presiona cualquier tecla para continuar...
pause >nul