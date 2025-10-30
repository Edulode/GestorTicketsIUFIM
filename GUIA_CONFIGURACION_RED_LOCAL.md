# 🌐 Guía de Configuración para Red Local - Gestor de Tickets IUFIM

## 📋 **Requisitos Previos**

### **Equipo que actuará como Servidor (Host)**
- Windows 10/11 o Linux
- PHP 8.1+ instalado
- MySQL/MariaDB o XAMPP/WAMP
- Composer instalado
- Node.js y NPM
- Conexión estable a la red local

### **Equipos Cliente**
- Cualquier SO con navegador web moderno
- Conexión a la misma red local
- No requieren software adicional

---

## ⚙️ **Configuración Paso a Paso**

### **1. Preparación del Entorno**

#### **Opción A: Con XAMPP (Recomendado para Windows)**
```bash
# 1. Descargar e instalar XAMPP
https://www.apachefriends.org/download.html

# 2. Iniciar Apache y MySQL desde el panel de control
# 3. Verificar que funcionen en http://localhost
```

#### **Opción B: Instalación Manual**
```bash
# 1. Instalar PHP
winget install PHP.PHP

# 2. Instalar Composer
https://getcomposer.org/download/

# 3. Instalar MySQL
winget install Oracle.MySQL
```

### **2. Configuración de Base de Datos**

#### **Para MySQL/MariaDB:**
```sql
-- Crear base de datos
CREATE DATABASE gestorticketsiufim CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Crear usuario para acceso remoto (opcional)
CREATE USER 'tickets_user'@'%' IDENTIFIED BY 'tickets_password';
GRANT ALL PRIVILEGES ON gestorticketsiufim.* TO 'tickets_user'@'%';
FLUSH PRIVILEGES;
```

#### **Para SQLite (Más simple):**
```bash
# Cambiar en .env
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1      # Comentar
# DB_PORT=3307           # Comentar  
# DB_DATABASE=           # Comentar
# DB_USERNAME=           # Comentar
# DB_PASSWORD=           # Comentar
```

### **3. Configuración del Proyecto Laravel**

#### **Archivo .env para Red Local:**

```env
# Configuración de aplicación
APP_NAME="Gestor Tickets IUFIM"
APP_ENV=production
APP_KEY=base64:lwiN/eZZ5Y81t7/E68aAu2KYzTmZncrHM/piFnL+UtQ=
APP_DEBUG=false
APP_URL=http://192.168.100.6:8000

# Base de datos - Opción MySQL
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestorticketsiufim
DB_USERNAME=root
DB_PASSWORD=tu_password_mysql

# Base de datos - Opción SQLite (más simple)
# DB_CONNECTION=sqlite
# DB_DATABASE=/absolute/path/to/database.sqlite

# Sesiones y cache
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

# Mail (opcional para notificaciones)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@gmail.com
MAIL_PASSWORD=tu_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tickets@iufim.local
MAIL_FROM_NAME="Gestor Tickets IUFIM"
```

### **4. Comandos de Configuración**

```bash
# 1. Instalar dependencias
composer install --optimize-autoloader --no-dev

# 2. Generar clave de aplicación
php artisan key:generate

# 3. Ejecutar migraciones
php artisan migrate

# 4. Ejecutar seeders (datos iniciales)
php artisan db:seed

# 5. Compilar assets para producción
npm install
npm run build

# 6. Optimizar aplicación
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 7. Crear link de storage (para archivos)
php artisan storage:link
```

### **5. Iniciar el Servidor**

#### **Método 1: PHP Built-in Server (Recomendado)**
```bash
# Desde la carpeta del proyecto
php artisan serve --host=0.0.0.0 --port=8000

# O especificar IP específica
php artisan serve --host=192.168.100.6 --port=8000
```

#### **Método 2: Con Apache (XAMPP)**
```bash
# 1. Copiar proyecto a htdocs/gestor-tickets/
# 2. Configurar Virtual Host en Apache
# 3. Acceder via http://192.168.100.6/gestor-tickets/public
```

### **6. Configuración de Firewall**

#### **Windows:**
```cmd
# Permitir conexiones en puerto 8000
netsh advfirewall firewall add rule name="Laravel App" dir=in action=allow protocol=TCP localport=8000

# O mediante interfaz gráfica:
# Panel de Control > Sistema y Seguridad > Firewall de Windows Defender
# Configuración avanzada > Reglas de entrada > Nueva regla...
```

#### **Linux:**
```bash
# UFW
sudo ufw allow 8000

# iptables
sudo iptables -A INPUT -p tcp --dport 8000 -j ACCEPT
```

---

## 🔗 **Acceso desde Otros Equipos**

### **URL de Acceso:**
```
http://192.168.100.6:8000
```

### **Verificar Conectividad:**
```bash
# Desde otro equipo, probar conectividad
ping 192.168.100.6
telnet 192.168.100.6 8000
```

---

## 🛡️ **Configuración de Seguridad**

### **1. Autenticación y Usuarios**

#### **Crear Usuario Administrador:**
```bash
php artisan tinker
```
```php
// En tinker
$user = new App\Models\User();
$user->name = 'Administrador IUFIM';
$user->email = 'admin@iufim.local';
$user->password = Hash::make('password_seguro_2024');
$user->save();
```

### **2. Configuración de Sesiones**
```env
# En .env - Configurar dominio de sesiones
SESSION_DOMAIN=192.168.100.6
SESSION_SECURE_COOKIE=false
SESSION_SAME_SITE=lax
```

### **3. Backup Automático**

#### **Script de Backup (backup.bat):**
```batch
@echo off
set FECHA=%date:~6,4%-%date:~3,2%-%date:~0,2%
set HORA=%time:~0,2%-%time:~3,2%

echo Creando backup del %FECHA% a las %HORA%

REM Backup de base de datos
mysqldump -u root -p gestorticketsiufim > backups\db_backup_%FECHA%_%HORA%.sql

REM Backup de archivos
xcopy /E /I /Y storage\app\public backups\files_%FECHA%_%HORA%\

echo Backup completado en backups\
pause
```

---

## 📱 **Configuración para Móviles**

### **Acceso Mobile-Friendly:**
```bash
# El sistema ya es responsive, solo acceder desde móvil:
http://192.168.100.6:8000

# Para crear acceso directo en móvil:
# 1. Abrir en navegador móvil
# 2. Menú > Agregar a pantalla de inicio
# 3. Nombrar como "Tickets IUFIM"
```

---

## 🔧 **Resolución de Problemas Comunes**

### **1. No se puede acceder desde otros equipos**
```bash
# Verificar firewall
netsh advfirewall show allprofiles

# Verificar puerto abierto
netstat -an | findstr :8000

# Verificar IP del servidor
ipconfig | findstr IPv4
```

### **2. Error de base de datos**
```bash
# Verificar conexión MySQL
php artisan tinker --execute="DB::connection()->getPdo();"

# Recrear migraciones
php artisan migrate:fresh --seed
```

### **3. Problemas de permisos**
```bash
# Windows - Dar permisos completos a carpetas
icacls storage /grant Users:F /T
icacls bootstrap\cache /grant Users:F /T

# Linux
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### **4. Assets no cargan**
```bash
# Recompilar assets
npm run build

# Limpiar caché
php artisan cache:clear
php artisan view:clear
php artisan config:clear
```

---

## 🚀 **Script de Inicio Automático**

### **start_server.bat**
```batch
@echo off
echo ===============================================
echo  GESTOR DE TICKETS IUFIM - SERVIDOR DE RED
echo ===============================================
echo.
echo Iniciando servidor en: http://192.168.100.6:8000
echo.
echo Presiona Ctrl+C para detener el servidor
echo.

cd /d "C:\ruta\al\proyecto\GestorTicketsIUFIM"
php artisan serve --host=0.0.0.0 --port=8000
```

### **Para ejecutar automáticamente al iniciar Windows:**
```bash
# 1. Crear acceso directo de start_server.bat
# 2. Copiar a: %APPDATA%\Microsoft\Windows\Start Menu\Programs\Startup
# 3. El servidor iniciará automáticamente con Windows
```

---

## 📊 **Monitoreo y Estadísticas**

### **Log de Accesos:**
```bash
# Ver logs de Laravel
tail -f storage/logs/laravel.log

# Monitorear conexiones activas
netstat -an | findstr :8000
```

### **Backup Programado (Task Scheduler):**
```bash
# Crear tarea programada para backup diario
# Panel de Control > Herramientas administrativas > Programador de tareas
# Programar backup.bat para ejecutar diariamente
```

---

## ⚡ **Optimización de Rendimiento**

### **Para muchos usuarios concurrentes:**
```bash
# Aumentar workers de PHP
PHP_CLI_SERVER_WORKERS=8

# Optimizar base de datos
php artisan db:seed --class=DatabaseOptimizationSeeder

# Configurar cache distribuido (si es necesario)
CACHE_STORE=redis
REDIS_HOST=192.168.100.6
```

---

## 📋 **Checklist Final**

- [ ] ✅ PHP 8.1+ instalado
- [ ] ✅ Base de datos configurada y conectada
- [ ] ✅ Firewall configurado (puerto 8000 abierto)
- [ ] ✅ IP estática configurada o IP actual documentada
- [ ] ✅ Migraciones y seeders ejecutados
- [ ] ✅ Assets compilados para producción
- [ ] ✅ Usuario administrador creado
- [ ] ✅ Servidor iniciado y accesible desde red
- [ ] ✅ Backup configurado
- [ ] ✅ Documentación entregada a usuarios

---

## 👥 **Guía para Usuarios Finales**

### **Acceso al Sistema:**
1. Abrir navegador web
2. Ir a: `http://192.168.100.6:8000`
3. Usar credenciales proporcionadas por el administrador

### **Funcionalidades Disponibles:**
- ✅ Crear y gestionar tickets
- ✅ Ver reportes y estadísticas
- ✅ Administrar categorías de servicio
- ✅ Gestión completa desde cualquier dispositivo

---

**📞 Soporte Técnico:** 
- Documentar IP del servidor: `192.168.100.6:8000`
- Mantener backup actualizado
- Monitorear logs regularmente
- Actualizar sistema según sea necesario