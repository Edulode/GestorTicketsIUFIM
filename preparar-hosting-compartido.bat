@echo off
REM 📦 Preparar proyecto para Hosting Compartido
REM Gestor de Tickets IUFIM

echo ================================================
echo 📦 PREPARAR PARA HOSTING COMPARTIDO - GESTOR TICKETS IUFIM
echo ================================================
echo.

REM Verificar que estamos en el directorio correcto
if not exist "artisan" (
    echo ❌ Error: Este script debe ejecutarse desde la carpeta del proyecto Laravel
    pause
    exit /b 1
)

echo 🔍 Verificando dependencias...

REM Verificar Composer
composer --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Error: Composer no encontrado
    echo Instalar desde: https://getcomposer.org/download/
    pause
    exit /b 1
)

REM Verificar Node.js (opcional)
npm --version >nul 2>&1
if %errorlevel% equ 0 (
    set HAS_NODE=1
    echo ✅ Node.js encontrado
) else (
    set HAS_NODE=0
    echo ⚠️ Node.js no encontrado - assets no se compilarán
)

echo.
echo 📦 Preparando archivos para hosting compartido...

REM Instalar dependencias de producción
echo 🔧 Instalando dependencias PHP...
composer install --optimize-autoloader --no-dev

REM Compilar assets si Node.js está disponible
if %HAS_NODE%==1 (
    echo 🎨 Compilando assets...
    call npm install
    call npm run build
)

REM Crear archivo .env para hosting compartido
echo 📝 Creando archivo .env para hosting compartido...
if exist ".env.shared" del ".env.shared"

echo APP_NAME="Gestor Tickets IUFIM" >> .env.shared
echo APP_ENV=production >> .env.shared
echo APP_KEY= >> .env.shared
echo APP_DEBUG=false >> .env.shared
echo APP_URL=https://tu-sitio.com >> .env.shared
echo. >> .env.shared
echo DB_CONNECTION=mysql >> .env.shared
echo DB_HOST=localhost >> .env.shared
echo DB_PORT=3306 >> .env.shared
echo DB_DATABASE=nombre_db_del_hosting >> .env.shared
echo DB_USERNAME=usuario_db_del_hosting >> .env.shared
echo DB_PASSWORD=password_db_del_hosting >> .env.shared
echo. >> .env.shared
echo CACHE_DRIVER=file >> .env.shared
echo SESSION_DRIVER=file >> .env.shared
echo QUEUE_CONNECTION=sync >> .env.shared
echo. >> .env.shared
echo MAIL_MAILER=smtp >> .env.shared
echo MAIL_HOST=smtp.gmail.com >> .env.shared
echo MAIL_PORT=587 >> .env.shared
echo MAIL_USERNAME= >> .env.shared
echo MAIL_PASSWORD= >> .env.shared
echo MAIL_ENCRYPTION=tls >> .env.shared
echo MAIL_FROM_ADDRESS=tickets@tu-sitio.com >> .env.shared
echo MAIL_FROM_NAME="Gestor Tickets IUFIM" >> .env.shared

REM Crear instrucciones de instalación
echo 📋 Creando instrucciones de instalación...
if exist "INSTRUCCIONES_HOSTING_COMPARTIDO.txt" del "INSTRUCCIONES_HOSTING_COMPARTIDO.txt"

echo ================================================ >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo INSTRUCCIONES PARA HOSTING COMPARTIDO >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo ================================================ >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo. >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo 📋 PASOS A SEGUIR: >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo. >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo 1. SUBIR ARCHIVOS: >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo    - Subir TODO el contenido de esta carpeta a tu hosting >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo    - Pueden ir en carpeta principal o subcarpeta >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo. >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo 2. CONFIGURAR DOMINIO: >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo    - Si el hosting requiere carpeta 'public_html' o 'www': >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo    - Mover contenido de carpeta 'public/' a 'public_html/' >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo    - Editar public_html/index.php y cambiar rutas: >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo      require __DIR__.'/../vendor/autoload.php'; >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo      $app = require_once __DIR__.'/../bootstrap/app.php'; >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo. >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo 3. CREAR BASE DE DATOS: >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo    - Crear base de datos MySQL desde panel de control >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo    - Anotar: nombre DB, usuario, contraseña >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo. >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo 4. CONFIGURAR .ENV: >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo    - Renombrar '.env.shared' a '.env' >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo    - Editar .env con datos reales: >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo      * APP_URL=https://tu-dominio.com >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo      * DB_DATABASE=nombre_real_db >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo      * DB_USERNAME=usuario_real_db >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo      * DB_PASSWORD=password_real_db >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo. >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo 5. GENERAR CLAVE (via terminal o File Manager): >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo    php artisan key:generate >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo. >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo 6. EJECUTAR MIGRACIONES: >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo    php artisan migrate --force >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo    php artisan db:seed --force >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo. >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo 7. CONFIGURAR PERMISOS: >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo    - Dar permisos 755 a carpetas storage/ y bootstrap/cache/ >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo    - Algunos hostings lo hacen automáticamente >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo. >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo 8. CREAR USUARIO ADMINISTRADOR: >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo    php artisan tinker >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo    $user = new App\Models\User(); >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo    $user-^>name = 'Admin'; >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo    $user-^>email = 'admin@iufim.edu'; >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo    $user-^>password = Hash::make('tu_password'); >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo    $user-^>save(); >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo. >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo ================================================ >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo SOLUCIÓN DE PROBLEMAS COMUNES: >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo ================================================ >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo. >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo ❌ Error 500: >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo    - Verificar permisos de storage/ y bootstrap/cache/ >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo    - Verificar que .env tenga APP_KEY generada >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo    - Verificar conexión a base de datos >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo. >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo ❌ Páginas sin estilos: >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo    - Verificar que public/build/ se subió correctamente >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo    - Verificar APP_URL en .env >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo. >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo ❌ Error de base de datos: >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo    - Verificar datos de conexión DB en .env >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo    - Verificar que base de datos existe >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo    - Ejecutar migraciones: php artisan migrate --force >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo. >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo 📞 CONTACTO PARA SOPORTE: >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo    - Documentar URL exacta y mensaje de error >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo    - Revisar logs del hosting si están disponibles >> INSTRUCCIONES_HOSTING_COMPARTIDO.txt

REM Crear directorio temporal y comprimir
echo 📦 Creando paquete de archivos...
if exist "hosting-compartido" rmdir /s /q hosting-compartido
mkdir hosting-compartido

REM Copiar archivos necesarios
echo 📁 Copiando archivos necesarios...
xcopy /E /I /Q app hosting-compartido\app\
xcopy /E /I /Q bootstrap hosting-compartido\bootstrap\
xcopy /E /I /Q config hosting-compartido\config\
xcopy /E /I /Q database hosting-compartido\database\
xcopy /E /I /Q public hosting-compartido\public\
xcopy /E /I /Q resources hosting-compartido\resources\
xcopy /E /I /Q routes hosting-compartido\routes\
xcopy /E /I /Q storage hosting-compartido\storage\
xcopy /E /I /Q vendor hosting-compartido\vendor\

REM Copiar archivos individuales
copy artisan hosting-compartido\
copy composer.json hosting-compartido\
copy composer.lock hosting-compartido\
copy .env.shared hosting-compartido\
copy INSTRUCCIONES_HOSTING_COMPARTIDO.txt hosting-compartido\

REM Crear estructura de directorios necesaria
mkdir hosting-compartido\storage\logs
mkdir hosting-compartido\storage\framework\cache
mkdir hosting-compartido\storage\framework\sessions
mkdir hosting-compartido\storage\framework\views
mkdir hosting-compartido\bootstrap\cache

REM Crear archivo .htaccess para Apache
echo RewriteEngine On > hosting-compartido\public\.htaccess
echo RewriteCond %%{REQUEST_FILENAME} !-d >> hosting-compartido\public\.htaccess
echo RewriteCond %%{REQUEST_FILENAME} !-f >> hosting-compartido\public\.htaccess
echo RewriteRule . index.php [L] >> hosting-compartido\public\.htaccess

echo.
echo ================================================
echo ✅ PREPARACIÓN COMPLETADA
echo ================================================
echo.
echo 📦 Archivos preparados en carpeta: hosting-compartido\
echo 📋 Instrucciones detalladas: INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo.
echo 📤 PRÓXIMOS PASOS:
echo 1. Comprimir carpeta 'hosting-compartido' en ZIP
echo 2. Subir ZIP al hosting y extraer
echo 3. Seguir instrucciones en INSTRUCCIONES_HOSTING_COMPARTIDO.txt
echo.
echo 💡 HOSTINGS RECOMENDADOS PARA LARAVEL:
echo - SiteGround (soporte Laravel excelente)
echo - A2 Hosting (optimizado para PHP)
echo - InMotion (buen precio/rendimiento)
echo.
echo ⚠️ IMPORTANTE:
echo - Verificar que el hosting soporte PHP 8.1+
echo - Verificar que tenga extensiones PHP necesarias
echo - Contactar soporte del hosting si hay problemas
echo.

echo ¿Crear archivo ZIP automáticamente? (requiere 7-Zip instalado)
set /p CREATE_ZIP="S/N: "
if /i "%CREATE_ZIP%"=="S" (
    7z a -tzip hosting-compartido.zip hosting-compartido\* >nul 2>&1
    if %errorlevel% equ 0 (
        echo ✅ Archivo hosting-compartido.zip creado
    ) else (
        echo ⚠️ No se pudo crear ZIP automáticamente
        echo Comprimir manualmente la carpeta 'hosting-compartido'
    )
)

echo.
echo ✅ Preparación completada. Presiona cualquier tecla para continuar...
pause >nul