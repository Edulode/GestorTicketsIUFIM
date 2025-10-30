@echo off
setlocal enabledelayedexpansion

echo ===============================================
echo  BACKUP GESTOR DE TICKETS IUFIM
echo ===============================================
echo.

REM Crear carpeta de backups si no existe
if not exist "backups" mkdir backups

REM Generar nombre con fecha y hora
for /f "tokens=1-4 delims=/ " %%i in ('date /t') do (
    set FECHA=%%l-%%j-%%k
)
for /f "tokens=1-2 delims=: " %%i in ('time /t') do (
    set HORA=%%i-%%j
)
set HORA=!HORA: =0!

set BACKUP_NAME=backup_!FECHA!_!HORA!

echo Creando backup: !BACKUP_NAME!
echo.

REM Backup de base de datos
echo [1/3] Respaldando base de datos...
php artisan db:backup --path=backups\!BACKUP_NAME!_database.sql 2>nul
if %errorlevel% neq 0 (
    echo Intentando backup manual de MySQL...
    mysqldump -u root -p gestorticketsiufim > backups\!BACKUP_NAME!_database.sql 2>nul
    if %errorlevel% neq 0 (
        echo Advertencia: No se pudo crear backup de base de datos
        echo Verifica la configuracion de MySQL
    ) else (
        echo ✓ Backup de base de datos creado
    )
) else (
    echo ✓ Backup de base de datos creado
)

REM Backup de archivos subidos
echo [2/3] Respaldando archivos...
if exist "storage\app\public" (
    xcopy /E /I /Y "storage\app\public" "backups\!BACKUP_NAME!_files\" >nul
    echo ✓ Archivos respaldados
) else (
    echo - No hay archivos que respaldar
)

REM Backup de configuracion
echo [3/3] Respaldando configuracion...
copy ".env" "backups\!BACKUP_NAME!_env.txt" >nul
echo ✓ Configuracion respaldada

echo.
echo ===============================================
echo  BACKUP COMPLETADO
echo ===============================================
echo Archivos creados en carpeta 'backups':
echo - !BACKUP_NAME!_database.sql
echo - !BACKUP_NAME!_files\
echo - !BACKUP_NAME!_env.txt
echo.
echo Fecha: !FECHA! Hora: !HORA!
echo ===============================================
echo.

REM Limpiar backups antiguos (mantener ultimos 10)
echo Limpiando backups antiguos...
for /f "skip=10 delims=" %%F in ('dir /b /o-d backups\backup_*_database.sql 2^>nul') do (
    del "backups\%%F" 2>nul
    echo Eliminado backup antiguo: %%F
)

echo.
echo Proceso completado
pause