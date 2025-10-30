# 🌐 Guía de Implementación Remota - Gestor de Tickets IUFIM

## 📋 **Opciones de Hosting Remoto**

### **🏢 Opción 1: Servidor VPS (Recomendado)**
**Costo:** $5-20 USD/mes | **Dificultad:** Media | **Control:** Total

**Proveedores Recomendados:**
- **DigitalOcean** - $6/mes - Muy fácil de usar
- **Linode** - $5/mes - Excelente rendimiento  
- **Vultr** - $6/mes - Buena velocidad
- **AWS Lightsail** - $3.50/mes - Integración AWS

### **☁️ Opción 2: Plataforma como Servicio (PaaS)**
**Costo:** $0-10 USD/mes | **Dificultad:** Baja | **Control:** Medio

**Proveedores Recomendados:**
- **Heroku** - Gratis hasta cierto uso
- **Railway** - $5/mes con dominio
- **Vercel** - Para frontend + API
- **Render** - Gratis para proyectos pequeños

### **🏠 Opción 3: Hosting Compartido**
**Costo:** $3-8 USD/mes | **Dificultad:** Baja | **Control:** Limitado

**Proveedores con PHP/MySQL:**
- **SiteGround** - Excelente soporte Laravel
- **A2 Hosting** - Optimizado para PHP
- **InMotion** - Buen precio/rendimiento

### **🐳 Opción 4: Contenedores Docker**
**Costo:** Variable | **Dificultad:** Alta | **Control:** Total

**Plataformas:**
- **Docker Hub + VPS**
- **Google Cloud Run**
- **AWS ECS**
- **Azure Container Instances**

---

## 🚀 **Implementación Paso a Paso - VPS (DigitalOcean)**

### **Paso 1: Crear Servidor**
```bash
# Especificaciones mínimas recomendadas:
- CPU: 1 vCore
- RAM: 1GB (2GB recomendado)
- Storage: 25GB SSD
- OS: Ubuntu 22.04 LTS
- Ubicación: Más cercana a usuarios
```

### **Paso 2: Configuración Inicial del Servidor**
```bash
# Conectar via SSH
ssh root@tu-servidor-ip

# Actualizar sistema
apt update && apt upgrade -y

# Instalar dependencias básicas
apt install -y curl wget git unzip software-properties-common

# Instalar PHP 8.2
add-apt-repository ppa:ondrej/php -y
apt update
apt install -y php8.2 php8.2-fpm php8.2-mysql php8.2-xml php8.2-curl php8.2-zip php8.2-mbstring php8.2-bcmath php8.2-gd php8.2-sqlite3

# Instalar Composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# Instalar Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
apt install -y nodejs

# Instalar Nginx
apt install -y nginx

# Instalar MySQL
apt install -y mysql-server
mysql_secure_installation

# Instalar Certbot (SSL gratuito)
apt install -y certbot python3-certbot-nginx
```

### **Paso 3: Configurar Base de Datos**
```bash
# Acceder a MySQL
mysql -u root -p

# Crear base de datos y usuario
CREATE DATABASE gestorticketsiufim;
CREATE USER 'tickets_user'@'localhost' IDENTIFIED BY 'password_seguro_2024';
GRANT ALL PRIVILEGES ON gestorticketsiufim.* TO 'tickets_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### **Paso 4: Subir y Configurar Aplicación**
```bash
# Ir al directorio web
cd /var/www

# Clonar repositorio (o subir archivos)
git clone https://github.com/TuUsuario/GestorTicketsIUFIM.git
# O usar scp/rsync para subir archivos locales

# Cambiar al directorio del proyecto
cd GestorTicketsIUFIM

# Instalar dependencias PHP
composer install --optimize-autoloader --no-dev

# Instalar dependencias Node.js
npm install
npm run build

# Configurar permisos
chown -R www-data:www-data /var/www/GestorTicketsIUFIM
chmod -R 755 /var/www/GestorTicketsIUFIM
chmod -R 775 /var/www/GestorTicketsIUFIM/storage
chmod -R 775 /var/www/GestorTicketsIUFIM/bootstrap/cache
```

### **Paso 5: Configurar .env para Producción**
```bash
# Copiar archivo de configuración
cp .env.example .env

# Editar configuración
nano .env
```

```env
# Configuración para producción
APP_NAME="Gestor Tickets IUFIM"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://tu-dominio.com

# Base de datos
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestorticketsiufim
DB_USERNAME=tickets_user
DB_PASSWORD=password_seguro_2024

# Cache y sesiones
CACHE_DRIVER=database
SESSION_DRIVER=database
QUEUE_CONNECTION=database

# Mail (configurar según proveedor)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=tu-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tickets@tu-dominio.com
MAIL_FROM_NAME="Gestor Tickets IUFIM"
```

### **Paso 6: Finalizar Configuración Laravel**
```bash
# Generar clave de aplicación
php artisan key:generate

# Ejecutar migraciones
php artisan migrate

# Ejecutar seeders
php artisan db:seed

# Crear enlaces simbólicos
php artisan storage:link

# Optimizar para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### **Paso 7: Configurar Nginx**
```bash
# Crear configuración del sitio
nano /etc/nginx/sites-available/gestortickets
```

```nginx
server {
    listen 80;
    server_name tu-dominio.com www.tu-dominio.com;
    root /var/www/GestorTicketsIUFIM/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

```bash
# Habilitar sitio
ln -s /etc/nginx/sites-available/gestortickets /etc/nginx/sites-enabled/
nginx -t
systemctl reload nginx
```

### **Paso 8: Configurar SSL (HTTPS)**
```bash
# Obtener certificado SSL gratuito
certbot --nginx -d tu-dominio.com -d www.tu-dominio.com

# Renovación automática
crontab -e
# Agregar línea:
0 12 * * * /usr/bin/certbot renew --quiet
```

---

## ☁️ **Implementación en Heroku (Gratuito/Fácil)**

### **Paso 1: Preparar Aplicación**
```bash
# Instalar Heroku CLI
# https://devcenter.heroku.com/articles/heroku-cli

# Login en Heroku
heroku login

# Crear aplicación
heroku create gestor-tickets-iufim
```

### **Paso 2: Configurar para Heroku**

Crear `Procfile`:
```bash
echo "web: vendor/bin/heroku-php-apache2 public/" > Procfile
```

Crear `runtime.txt`:
```bash
echo "php-8.2.0" > runtime.txt
```

### **Paso 3: Configurar Variables de Entorno**
```bash
# Configurar variables
heroku config:set APP_NAME="Gestor Tickets IUFIM"
heroku config:set APP_ENV=production
heroku config:set APP_DEBUG=false
heroku config:set APP_KEY=base64:tu-clave-generada
heroku config:set APP_URL=https://gestor-tickets-iufim.herokuapp.com

# Base de datos (usar JawsDB MySQL addon)
heroku addons:create jawsdb:kitefin
heroku config:get JAWSDB_URL
# Configurar DB_ variables basadas en JAWSDB_URL

# Configurar email
heroku config:set MAIL_MAILER=smtp
heroku config:set MAIL_HOST=smtp.gmail.com
heroku config:set MAIL_PORT=587
heroku config:set MAIL_USERNAME=tu-email@gmail.com
heroku config:set MAIL_PASSWORD=tu-app-password
```

### **Paso 4: Deploy**
```bash
# Inicializar git (si no existe)
git init
git add .
git commit -m "Initial commit"

# Conectar con Heroku
heroku git:remote -a gestor-tickets-iufim

# Deploy
git push heroku main

# Ejecutar migraciones
heroku run php artisan migrate --force
heroku run php artisan db:seed --force
```

---

## 🏠 **Implementación en Hosting Compartido**

### **Requisitos del Hosting:**
- PHP 8.1+
- MySQL/MariaDB
- Composer (o permitir instalación)
- SSH (opcional pero recomendado)

### **Paso 1: Preparar Archivos**
```bash
# En tu computadora local
composer install --optimize-autoloader --no-dev
npm install
npm run build

# Crear ZIP con archivos necesarios
zip -r proyecto.zip . -x "node_modules/*" ".git/*" "tests/*"
```

### **Paso 2: Subir y Configurar**
1. **Subir archivos** via FTP/cPanel File Manager
2. **Crear base de datos** en cPanel/Panel de control
3. **Configurar .env** con datos del hosting
4. **Mover public/** al directorio público (public_html)
5. **Ajustar rutas** en index.php si es necesario

### **Configuración típica para hosting compartido:**
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-sitio.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=nombre_db_asignada
DB_USERNAME=usuario_db_asignado
DB_PASSWORD=password_db_asignada
```

---

## 🔧 **Scripts de Deploy Automatizado**

### **deploy.sh** (para VPS)
```bash
#!/bin/bash

echo "🚀 Iniciando deploy remoto..."

# Variables
SERVER="user@tu-servidor.com"
PROJECT_PATH="/var/www/GestorTicketsIUFIM"

# Subir archivos
echo "📤 Subiendo archivos..."
rsync -avz --exclude 'node_modules' --exclude '.git' ./ $SERVER:$PROJECT_PATH/

# Ejecutar comandos remotos
echo "⚙️ Configurando en servidor..."
ssh $SERVER << 'EOF'
cd /var/www/GestorTicketsIUFIM
composer install --optimize-autoloader --no-dev
npm install
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
sudo systemctl reload nginx
EOF

echo "✅ Deploy completado!"
```

### **deploy-heroku.sh**
```bash
#!/bin/bash

echo "🚀 Deploy a Heroku..."

# Commit cambios
git add .
git commit -m "Deploy $(date)"

# Push a Heroku
git push heroku main

# Ejecutar migraciones si es necesario
heroku run php artisan migrate --force

echo "✅ Deploy a Heroku completado!"
```

---

## 🛡️ **Configuración de Seguridad para Producción**

### **Firewall (UFW) - VPS**
```bash
# Configurar firewall básico
ufw default deny incoming
ufw default allow outgoing
ufw allow ssh
ufw allow 'Nginx Full'
ufw enable
```

### **Backup Automatizado**
```bash
# Script de backup remoto
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
mysqldump -u tickets_user -p gestorticketsiufim > backup_db_$DATE.sql
tar -czf backup_files_$DATE.tar.gz storage/app/public/
aws s3 cp backup_db_$DATE.sql s3://tu-bucket/backups/
aws s3 cp backup_files_$DATE.tar.gz s3://tu-bucket/backups/
```

### **Monitoreo**
```bash
# Instalar herramientas de monitoreo
apt install -y htop iotop nethogs
pip3 install glances

# Configurar logs
nano /etc/logrotate.d/laravel
```

---

## 💰 **Estimación de Costos**

### **VPS (Recomendado)**
```
DigitalOcean Droplet: $6/mes
Dominio: $10-15/año
SSL: Gratis (Let's Encrypt)
Total: ~$7/mes + dominio
```

### **Heroku**
```
Plan Básico: $7/mes
Base de datos: $9/mes (JawsDB)
Dominio personalizado: $10-15/año
Total: ~$16/mes + dominio
```

### **Hosting Compartido**
```
Plan básico: $3-8/mes
Dominio: Incluido o $10-15/año
SSL: Incluido
Total: $3-8/mes
```

---

## 📋 **Checklist de Implementación Remota**

- [ ] ✅ Seleccionar proveedor de hosting
- [ ] ✅ Configurar servidor/cuenta
- [ ] ✅ Registrar dominio
- [ ] ✅ Configurar DNS
- [ ] ✅ Subir y configurar aplicación
- [ ] ✅ Configurar base de datos
- [ ] ✅ Instalar SSL/HTTPS
- [ ] ✅ Probar funcionalidad completa
- [ ] ✅ Configurar backups
- [ ] ✅ Configurar monitoreo
- [ ] ✅ Documentar credenciales y accesos

---

## 🎯 **Recomendación Final**

**Para IUFIM recomiendo:**

1. **🥇 Primera opción:** DigitalOcean VPS ($6/mes)
   - Control total
   - Excelente rendimiento
   - Escalable
   - Buena documentación

2. **🥈 Segunda opción:** SiteGround Hosting ($6/mes)
   - Más fácil de administrar
   - Soporte técnico incluido
   - Optimizado para Laravel

3. **🥉 Tercera opción:** Heroku ($7/mes básico)
   - Deploy extremadamente fácil
   - Escalado automático
   - Ideal for pruebas

¿Te gustaría que creemos la implementación específica para alguna de estas opciones?