# 🖥️ INSTALACIÓN COMPLETA DESDE CERO - GESTOR TICKETS IUFIM

## 📋 **RESUMEN EJECUTIVO**
Esta guía te permitirá instalar el sistema de gestión de tickets en un equipo completamente limpio y configurarlo para funcionar automáticamente en red local cada vez que se encienda el equipo.

---

## 🎯 **FASE 1: PREPARACIÓN DEL EQUIPO (DESDE CERO)**

### **1.1 Verificar Especificaciones Mínimas**
- **Sistema Operativo:** Windows 10/11 (64-bit)
- **RAM:** Mínimo 4GB (recomendado 8GB)
- **Espacio en disco:** Mínimo 10GB libres
- **Red:** Conexión ethernet o Wi-Fi estable
- **Privilegios:** Cuenta de administrador

### **1.2 Preparar el Entorno de Windows**
```cmd
# 1. Abrir PowerShell como Administrador
# Click derecho en botón inicio > Windows PowerShell (Admin)

# 2. Habilitar ejecución de scripts
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser

# 3. Instalar Chocolatey (gestor de paquetes)
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://community.chocolatey.org/install.ps1'))
```

---

## 🔧 **FASE 2: INSTALACIÓN DE SOFTWARE BASE**

### **2.1 Instalar XAMPP (Apache + MySQL + PHP)**
```cmd
# Descargar desde navegador web
# Ir a: https://www.apachefriends.org/download.html
# Descargar XAMPP para Windows (versión PHP 8.2)

# Instalar en: C:\xampp (ruta por defecto)
# Durante instalación:
# ✅ Apache
# ✅ MySQL  
# ✅ PHP
# ✅ phpMyAdmin
# ❌ FileZilla (no necesario)
# ❌ Mercury (no necesario)
# ❌ Tomcat (no necesario)
```

### **2.2 Instalar Composer (Gestor de dependencias PHP)**
```cmd
# Abrir navegador y ir a: https://getcomposer.org/download/
# Descargar Composer-Setup.exe
# Ejecutar instalador
# Durante instalación, usar PHP de XAMPP: C:\xampp\php\php.exe
```

### **2.3 Instalar Node.js y NPM**
```cmd
# Ir a: https://nodejs.org/
# Descargar versión LTS (Long Term Support)
# Ejecutar instalador con opciones por defecto
# ✅ Add to PATH
# ✅ Install npm package manager
```

### **2.4 Instalar Git (Control de versiones)**
```cmd
# Ir a: https://git-scm.com/download/win
# Descargar Git for Windows
# Instalar con opciones por defecto
```

### **2.5 Verificar Instalaciones**
```cmd
# Abrir nueva ventana de PowerShell (NO como admin)
# Verificar versiones instaladas

php --version
# Debe mostrar: PHP 8.2.x

composer --version  
# Debe mostrar: Composer version 2.x.x

node --version
# Debe mostrar: v20.x.x o superior

npm --version
# Debe mostrar: 10.x.x o superior

git --version
# Debe mostrar: git version 2.x.x
```

---

## 📁 **FASE 3: OBTENER Y CONFIGURAR EL PROYECTO**

### **3.1 Crear Directorio de Trabajo**
```cmd
# Crear carpeta para proyectos web
mkdir C:\webprojects
cd C:\webprojects
```

### **3.2 Descargar el Proyecto**

#### **Opción A: Desde GitHub (si está público)**
```cmd
git clone https://github.com/Edulode/GestorTicketsIUFIM.git
cd GestorTicketsIUFIM
```

#### **Opción B: Transferir archivos manualmente**
```cmd
# Copiar toda la carpeta del proyecto desde USB/red
# Colocar en: C:\webprojects\GestorTicketsIUFIM
cd C:\webprojects\GestorTicketsIUFIM
```

### **3.3 Instalar Dependencias del Proyecto**
```cmd
# Navegar a la carpeta del proyecto
cd C:\webprojects\GestorTicketsIUFIM

# Instalar dependencias PHP
composer install --no-dev --optimize-autoloader

# Instalar dependencias Node.js
npm install

# Compilar assets para producción
npm run build
```

---

## 🗄️ **FASE 4: CONFIGURAR BASE DE DATOS**

### **4.1 Iniciar Servicios XAMPP**
```cmd
# Abrir XAMPP Control Panel (buscar en menú inicio)
# Click en "Start" junto a Apache
# Click en "Start" junto a MySQL
# Verificar que ambos muestren luces verdes
```

### **4.2 Crear Base de Datos**
```cmd
# Abrir navegador web
# Ir a: http://localhost/phpmyadmin/
# Click en "Bases de datos"
# Nombre: gestorticketsiufim
# Cotejamiento: utf8mb4_unicode_ci
# Click "Crear"
```

### **4.3 Configurar Variables de Entorno**
```cmd
# En la carpeta del proyecto, copiar archivo de configuración
copy .env.example .env

# Editar archivo .env con Notepad
notepad .env
```

**Contenido del archivo .env:**
```env
APP_NAME="Gestor Tickets IUFIM"
APP_ENV=production
APP_DEBUG=false
APP_TIMEZONE=America/Mexico_City
APP_URL=http://192.168.1.100:8000

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestorticketsiufim
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

CACHE_STORE=database
CACHE_PREFIX=

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@iufim.local"
MAIL_FROM_NAME="${APP_NAME}"
```

### **4.4 Generar Clave de Aplicación**
```cmd
cd C:\webprojects\GestorTicketsIUFIM
php artisan key:generate
```

### **4.5 Ejecutar Migraciones y Datos Iniciales**
```cmd
# Crear tablas en la base de datos
php artisan migrate

# Cargar datos iniciales
php artisan db:seed
```

---

## 🌐 **FASE 5: CONFIGURAR RED LOCAL**

### **5.1 Obtener IP del Equipo Servidor**
```cmd
# Obtener dirección IP local
ipconfig | findstr IPv4

# Ejemplo de salida:
# Dirección IPv4. . . . . . . . . . . : 192.168.1.100
# Anotar esta IP: 192.168.1.100
```

### **5.2 Configurar Firewall de Windows**
```cmd
# Abrir PowerShell como Administrador
# Agregar regla para puerto 8000
netsh advfirewall firewall add rule name="Gestor Tickets IUFIM" dir=in action=allow protocol=TCP localport=8000

# Verificar regla creada
netsh advfirewall firewall show rule name="Gestor Tickets IUFIM"
```

### **5.3 Actualizar Configuración con IP Real**
```cmd
# Editar .env nuevamente
notepad .env

# Cambiar línea APP_URL por la IP real:
APP_URL=http://192.168.1.100:8000
# (usar la IP que obtuviste en el paso 5.1)
```

---

## 🚀 **FASE 6: CONFIGURAR INICIO AUTOMÁTICO**

### **6.1 Crear Script de Inicio**
```cmd
# Crear archivo de script
notepad C:\webprojects\iniciar_gestor_tickets.bat
```

**Contenido del archivo .bat:**
```batch
@echo off
title GESTOR DE TICKETS IUFIM - SERVIDOR
color 0A

echo ============================================================
echo   SISTEMA DE GESTION DE TICKETS - INSTITUTO IUFIM
echo ============================================================
echo.
echo [INFO] Iniciando servicios necesarios...
echo.

REM Cambiar a directorio del proyecto
cd /d "C:\webprojects\GestorTicketsIUFIM"

REM Mostrar información del servidor
echo [INFO] Servidor iniciado en: http://192.168.1.100:8000
echo [INFO] Accesible desde cualquier equipo en la red local
echo.
echo [INSTRUCCIONES PARA USUARIOS]
echo 1. Abrir navegador web en cualquier equipo
echo 2. Ir a: http://192.168.1.100:8000
echo 3. Usar credenciales proporcionadas por el administrador
echo.
echo ============================================================
echo   PRESIONA CTRL+C PARA DETENER EL SERVIDOR
echo ============================================================
echo.

REM Limpiar cachés
php artisan config:clear > nul 2>&1
php artisan cache:clear > nul 2>&1

REM Iniciar servidor Laravel
php artisan serve --host=0.0.0.0 --port=8000

pause
```

### **6.2 Configurar XAMPP para Inicio Automático**
```cmd
# Abrir XAMPP Control Panel
# Click en "Config" (esquina superior derecha)
# Marcar ✅ "Autostart of modules"
# Marcar ✅ Apache
# Marcar ✅ MySQL
# Click "Save"
```

### **6.3 Configurar Inicio Automático del Script**
```cmd
# Crear acceso directo del script
# Click derecho en iniciar_gestor_tickets.bat
# "Crear acceso directo"
# Copiar el acceso directo

# Abrir carpeta de inicio automático
# Presionar Win+R
# Escribir: shell:startup
# Pegar el acceso directo en esta carpeta
```

---

## 👤 **FASE 7: CREAR USUARIO ADMINISTRADOR**

### **7.1 Acceder al Sistema**
```cmd
# Ejecutar el script de inicio
C:\webprojects\iniciar_gestor_tickets.bat

# Abrir navegador y ir a:
# http://192.168.1.100:8000
```

### **7.2 Crear Primer Usuario Administrador**
```cmd
# Abrir nueva ventana de PowerShell
cd C:\webprojects\GestorTicketsIUFIM

# Entrar al modo interactivo de Laravel
php artisan tinker
```

**En el prompt de Tinker:**
```php
// Crear usuario administrador
$user = new App\Models\User();
$user->name = 'Administrador IUFIM';
$user->email = 'admin@iufim.local';
$user->password = Hash::make('AdminIUFIM2024!');
$user->email_verified_at = now();
$user->save();

// Verificar que se creó
App\Models\User::count();

// Salir de tinker
exit
```

---

## 🔐 **FASE 8: CONFIGURACIÓN DE SEGURIDAD**

### **8.1 Optimizar Aplicación para Producción**
```cmd
cd C:\webprojects\GestorTicketsIUFIM

# Generar cachés de configuración
php artisan config:cache

# Generar caché de rutas
php artisan route:cache

# Generar caché de vistas
php artisan view:cache

# Crear enlace simbólico para archivos
php artisan storage:link
```

### **8.2 Configurar Backup Automático**
```cmd
# Crear directorio de backups
mkdir C:\webprojects\backups

# Crear script de backup
notepad C:\webprojects\backup_diario.bat
```

**Contenido del backup_diario.bat:**
```batch
@echo off
set FECHA=%date:~6,4%-%date:~3,2%-%date:~0,2%
set HORA=%time:~0,2%-%time:~3,2%
set HORA=%HORA: =0%

echo [%date% %time%] Iniciando backup automatico...

REM Crear carpeta de backup del día
mkdir "C:\webprojects\backups\%FECHA%"

REM Backup de base de datos
echo [%date% %time%] Respaldando base de datos...
"C:\xampp\mysql\bin\mysqldump.exe" -u root gestorticketsiufim > "C:\webprojects\backups\%FECHA%\database_%HORA%.sql"

REM Backup de archivos subidos
echo [%date% %time%] Respaldando archivos...
xcopy /E /I /Y "C:\webprojects\GestorTicketsIUFIM\storage\app" "C:\webprojects\backups\%FECHA%\storage_%HORA%\"

REM Backup del archivo .env
copy "C:\webprojects\GestorTicketsIUFIM\.env" "C:\webprojects\backups\%FECHA%\env_%HORA%.txt"

echo [%date% %time%] Backup completado en: C:\webprojects\backups\%FECHA%\
echo Backup automatico finalizado >> "C:\webprojects\backups\backup_log.txt"
```

### **8.3 Programar Backup Automático**
```cmd
# Abrir "Programador de tareas"
# Win+R > taskschd.msc
# Click derecho en "Biblioteca del Programador de tareas"
# "Crear tarea básica"
# Nombre: "Backup Gestor Tickets"
# Desencadenador: "Diariamente" a las 2:00 AM
# Acción: "Iniciar un programa"
# Programa: C:\webprojects\backup_diario.bat
```

---

## 🖥️ **FASE 9: CONFIGURAR SERVICIOS COMO SERVICIO WINDOWS**

### **9.1 Instalar NSSM (Non-Sucking Service Manager)**
```cmd
# Descargar desde: https://nssm.cc/download
# Extraer nssm.exe a C:\tools\nssm\
# O usar chocolatey:
choco install nssm
```

### **9.2 Crear Servicio para Laravel**
```cmd
# Crear archivo de servicio
notepad C:\webprojects\laravel_service.bat
```

**Contenido de laravel_service.bat:**
```batch
@echo off
cd /d "C:\webprojects\GestorTicketsIUFIM"
php artisan serve --host=0.0.0.0 --port=8000 --no-reload
```

### **9.3 Registrar como Servicio Windows**
```cmd
# Abrir PowerShell como Administrador
nssm install "GestorTicketsIUFIM" "C:\webprojects\laravel_service.bat"
nssm set "GestorTicketsIUFIM" Description "Servidor del Sistema de Gestión de Tickets IUFIM"
nssm set "GestorTicketsIUFIM" Start SERVICE_AUTO_START

# Iniciar el servicio
nssm start "GestorTicketsIUFIM"

# Verificar estado
sc query "GestorTicketsIUFIM"
```

---

## ✅ **FASE 10: VERIFICACIÓN FINAL**

### **10.1 Checklist de Verificación**
```cmd
# Ejecutar estas verificaciones:

# 1. Servicios XAMPP iniciados
http://localhost/phpmyadmin/

# 2. Base de datos creada y poblada
# En phpMyAdmin verificar que existe "gestorticketsiufim" con tablas

# 3. Aplicación Laravel accesible localmente
http://localhost:8000

# 4. Aplicación accesible desde red
http://192.168.1.100:8000

# 5. Login funcional
# Email: admin@iufim.local
# Password: AdminIUFIM2024!

# 6. Firewall configurado
netsh advfirewall firewall show rule name="Gestor Tickets IUFIM"

# 7. Servicio Windows activo
sc query "GestorTicketsIUFIM"
```

### **10.2 Verificar desde Otro Equipo**
```cmd
# Desde cualquier equipo en la red:
# 1. Abrir navegador web
# 2. Ir a: http://192.168.1.100:8000
# 3. Debe cargar la pantalla de login
# 4. Iniciar sesión con credenciales de administrador
```

---

## 📱 **FASE 11: CONFIGURACIÓN PARA DISPOSITIVOS MÓVILES**

### **11.1 Crear Acceso Directo en Móvil**
```
1. Abrir navegador en el móvil
2. Ir a: http://192.168.1.100:8000
3. En Android: Menú > Agregar a pantalla de inicio
4. En iOS: Compartir > Agregar a pantalla de inicio
5. Nombrar: "Tickets IUFIM"
```

### **11.2 Crear Código QR para Fácil Acceso**
```cmd
# Generar QR desde: https://qr-code-generator.com/
# URL: http://192.168.1.100:8000
# Imprimir y colocar en áreas comunes
```

---

## 🆘 **SECCIÓN DE SOPORTE Y SOLUCIÓN DE PROBLEMAS**

### **Problema 1: No se puede acceder desde otros equipos**
```cmd
# Diagnóstico:
ipconfig | findstr IPv4
ping 192.168.1.100
telnet 192.168.1.100 8000

# Soluciones:
netsh advfirewall firewall delete rule name="Gestor Tickets IUFIM"
netsh advfirewall firewall add rule name="Gestor Tickets IUFIM" dir=in action=allow protocol=TCP localport=8000
```

### **Problema 2: Error de base de datos**
```cmd
# Verificar MySQL corriendo en XAMPP
# Verificar credenciales en .env
php artisan migrate:status
php artisan migrate:fresh --seed
```

### **Problema 3: Página en blanco o error 500**
```cmd
# Verificar logs
type storage\logs\laravel.log

# Limpiar cachés
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Verificar permisos
icacls storage /grant Users:F /T
icacls bootstrap\cache /grant Users:F /T
```

### **Problema 4: Assets no cargan (CSS/JS)**
```cmd
npm run build
php artisan storage:link
```

---

## 📊 **MONITOREO Y MANTENIMIENTO**

### **Logs del Sistema**
```cmd
# Ver logs de Laravel
type C:\webprojects\GestorTicketsIUFIM\storage\logs\laravel.log

# Ver logs de Apache (XAMPP)
type C:\xampp\apache\logs\error.log
```

### **Actualizaciones del Sistema**
```cmd
# Actualizar dependencias
composer update
npm update && npm run build

# Aplicar nuevas migraciones
php artisan migrate

# Limpiar cachés
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 📋 **INFORMACIÓN DE REFERENCIA RÁPIDA**

### **URLs Importantes:**
- **Aplicación Principal:** http://192.168.1.100:8000
- **Panel MySQL:** http://localhost/phpmyadmin/
- **Panel XAMPP:** http://localhost/dashboard/

### **Credenciales por Defecto:**
- **Email:** admin@iufim.local
- **Password:** AdminIUFIM2024!

### **Puertos Utilizados:**
- **8000** - Aplicación Laravel
- **80** - Apache (XAMPP)  
- **3306** - MySQL

### **Archivos de Configuración Importantes:**
- **C:\webprojects\GestorTicketsIUFIM\.env** - Configuración principal
- **C:\webprojects\iniciar_gestor_tickets.bat** - Script de inicio
- **C:\webprojects\backup_diario.bat** - Script de backup

### **Comandos de Mantenimiento:**
```cmd
# Reiniciar aplicación
nssm restart "GestorTicketsIUFIM"

# Ver estado del servicio
sc query "GestorTicketsIUFIM"

# Backup manual
C:\webprojects\backup_diario.bat

# Limpiar cachés
cd C:\webprojects\GestorTicketsIUFIM
php artisan cache:clear
```

---

## 🎯 **RESUMEN EJECUTIVO DE LA INSTALACIÓN**

Esta guía ha cubierto:

✅ **Instalación completa desde cero** de todos los componentes necesarios
✅ **Configuración de red local** para acceso desde múltiples equipos  
✅ **Inicio automático** del sistema al encender el equipo
✅ **Seguridad básica** con firewall y usuario administrador
✅ **Backup automático** programado diariamente
✅ **Servicio Windows** para mayor estabilidad
✅ **Acceso móvil** responsivo desde cualquier dispositivo
✅ **Documentación completa** para soporte y mantenimiento

**El sistema estará disponible en:** `http://192.168.1.100:8000`

**Para soporte:** Consultar sección de solución de problemas o contactar al administrador del sistema.

---

**📅 Fecha de Instalación:** ________________  
**👤 Técnico Responsable:** ________________  
**📧 Contacto Soporte:** ________________  
**📱 Teléfono Emergencia:** ________________