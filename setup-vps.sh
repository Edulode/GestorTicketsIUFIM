#!/bin/bash

# 🔧 Script de Configuración Inicial para Servidor VPS
# Gestor de Tickets IUFIM - Ubuntu 22.04

set -e

# Colores
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

echo -e "${BLUE}🔧 CONFIGURACIÓN INICIAL VPS - GESTOR TICKETS IUFIM${NC}"
echo "========================================================="

# Verificar que somos root
if [ "$EUID" -ne 0 ]; then
    echo -e "${RED}❌ Este script debe ejecutarse como root${NC}"
    echo "Usar: sudo bash setup-vps.sh"
    exit 1
fi

# Solicitar información básica
echo -e "${YELLOW}📝 Configuración inicial${NC}"
read -p "🌐 Dominio (ej: tickets.iufim.edu): " DOMAIN
read -p "📧 Email para SSL y notificaciones: " EMAIL
read -p "🔐 Contraseña para base de datos: " DB_PASSWORD

if [ -z "$DOMAIN" ] || [ -z "$EMAIL" ] || [ -z "$DB_PASSWORD" ]; then
    echo -e "${RED}❌ Todos los campos son requeridos${NC}"
    exit 1
fi

echo ""
echo -e "${YELLOW}🔄 Actualizando sistema...${NC}"
apt update && apt upgrade -y

echo -e "${YELLOW}📦 Instalando dependencias básicas...${NC}"
apt install -y curl wget git unzip software-properties-common ufw htop

echo -e "${YELLOW}🐘 Instalando PHP 8.2...${NC}"
add-apt-repository ppa:ondrej/php -y
apt update
apt install -y php8.2 php8.2-fpm php8.2-mysql php8.2-xml php8.2-curl \
    php8.2-zip php8.2-mbstring php8.2-bcmath php8.2-gd php8.2-sqlite3 \
    php8.2-intl php8.2-redis php8.2-imagick

echo -e "${YELLOW}🎼 Instalando Composer...${NC}"
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer

echo -e "${YELLOW}📦 Instalando Node.js 18...${NC}"
curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
apt install -y nodejs

echo -e "${YELLOW}🌐 Instalando y configurando Nginx...${NC}"
apt install -y nginx

# Configurar Nginx
cat > /etc/nginx/sites-available/gestortickets << EOF
server {
    listen 80;
    server_name $DOMAIN www.$DOMAIN;
    root /var/www/GestorTicketsIUFIM/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;

    # Aumentar límites para uploads
    client_max_body_size 10M;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Cache static files
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|pdf|txt|tar|zip)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
EOF

# Habilitar sitio
ln -sf /etc/nginx/sites-available/gestortickets /etc/nginx/sites-enabled/
rm -f /etc/nginx/sites-enabled/default
nginx -t

echo -e "${YELLOW}🗄️ Instalando y configurando MySQL...${NC}"
apt install -y mysql-server

# Configuración segura de MySQL
mysql << EOF
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '$DB_PASSWORD';
CREATE DATABASE gestorticketsiufim CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'tickets_user'@'localhost' IDENTIFIED BY '$DB_PASSWORD';
GRANT ALL PRIVILEGES ON gestorticketsiufim.* TO 'tickets_user'@'localhost';
FLUSH PRIVILEGES;
EOF

echo -e "${YELLOW}🔒 Configurando firewall...${NC}"
ufw default deny incoming
ufw default allow outgoing
ufw allow ssh
ufw allow 'Nginx Full'
ufw --force enable

echo -e "${YELLOW}🔐 Instalando Certbot para SSL...${NC}"
apt install -y certbot python3-certbot-nginx

echo -e "${YELLOW}📁 Creando estructura de directorios...${NC}"
mkdir -p /var/www/GestorTicketsIUFIM
mkdir -p /var/www/GestorTicketsIUFIM/storage/logs
mkdir -p /var/www/GestorTicketsIUFIM/bootstrap/cache

# Configurar permisos
chown -R www-data:www-data /var/www/GestorTicketsIUFIM
chmod -R 755 /var/www/GestorTicketsIUFIM

echo -e "${YELLOW}⚙️ Configurando PHP...${NC}"
# Configurar PHP para producción
sed -i 's/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/' /etc/php/8.2/fpm/php.ini
sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 10M/' /etc/php/8.2/fpm/php.ini
sed -i 's/post_max_size = 8M/post_max_size = 10M/' /etc/php/8.2/fpm/php.ini
sed -i 's/max_execution_time = 30/max_execution_time = 300/' /etc/php/8.2/fpm/php.ini
sed -i 's/memory_limit = 128M/memory_limit = 256M/' /etc/php/8.2/fpm/php.ini

echo -e "${YELLOW}🔄 Reiniciando servicios...${NC}"
systemctl restart php8.2-fpm
systemctl restart nginx
systemctl restart mysql

# Habilitar servicios al arranque
systemctl enable php8.2-fpm
systemctl enable nginx
systemctl enable mysql

echo -e "${YELLOW}📝 Creando archivos de configuración...${NC}"

# Crear archivo .env base
cat > /var/www/GestorTicketsIUFIM/.env << EOF
APP_NAME="Gestor Tickets IUFIM"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://$DOMAIN

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestorticketsiufim
DB_USERNAME=tickets_user
DB_PASSWORD=$DB_PASSWORD

CACHE_DRIVER=database
SESSION_DRIVER=database
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tickets@$DOMAIN
MAIL_FROM_NAME="Gestor Tickets IUFIM"

LOG_CHANNEL=daily
LOG_LEVEL=warning
EOF

# Crear script de backup
cat > /usr/local/bin/backup-tickets.sh << EOF
#!/bin/bash
DATE=\$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/var/www/GestorTicketsIUFIM/storage/backups"
mkdir -p \$BACKUP_DIR

# Backup de base de datos
mysqldump -u tickets_user -p'$DB_PASSWORD' gestorticketsiufim > \$BACKUP_DIR/db_backup_\$DATE.sql

# Backup de archivos
tar -czf \$BACKUP_DIR/files_backup_\$DATE.tar.gz -C /var/www/GestorTicketsIUFIM storage/app/public

# Limpiar backups antiguos (mantener últimos 7 días)
find \$BACKUP_DIR -name "*.sql" -mtime +7 -delete
find \$BACKUP_DIR -name "*.tar.gz" -mtime +7 -delete

echo "Backup completado: \$DATE"
EOF

chmod +x /usr/local/bin/backup-tickets.sh

# Programar backup diario
(crontab -l 2>/dev/null; echo "0 2 * * * /usr/local/bin/backup-tickets.sh") | crontab -

echo -e "${YELLOW}🔒 Configurando SSL...${NC}"
certbot --nginx -d $DOMAIN -d www.$DOMAIN --email $EMAIL --agree-tos --no-eff-email --redirect

# Configurar renovación automática
(crontab -l 2>/dev/null; echo "0 12 * * * /usr/bin/certbot renew --quiet") | crontab -

echo ""
echo -e "${GREEN}✅ CONFIGURACIÓN INICIAL COMPLETADA${NC}"
echo "=========================================="
echo ""
echo -e "${BLUE}📋 Información del servidor:${NC}"
echo -e "🌐 Dominio: ${YELLOW}$DOMAIN${NC}"
echo -e "📧 Email: ${YELLOW}$EMAIL${NC}"
echo -e "🗄️ Base de datos: ${YELLOW}gestorticketsiufim${NC}"
echo -e "👤 Usuario DB: ${YELLOW}tickets_user${NC}"
echo -e "📁 Ruta web: ${YELLOW}/var/www/GestorTicketsIUFIM${NC}"
echo ""
echo -e "${BLUE}🔧 Próximos pasos:${NC}"
echo "1. Subir archivos del proyecto a /var/www/GestorTicketsIUFIM"
echo "2. Ejecutar: php artisan migrate --force"
echo "3. Ejecutar: php artisan db:seed --force"
echo "4. Configurar permisos: chown -R www-data:www-data /var/www/GestorTicketsIUFIM"
echo ""
echo -e "${BLUE}🛠️ Comandos útiles:${NC}"
echo "sudo systemctl restart nginx        (reiniciar nginx)"
echo "sudo systemctl restart php8.2-fpm  (reiniciar php)"
echo "sudo /usr/local/bin/backup-tickets.sh  (backup manual)"
echo "sudo tail -f /var/log/nginx/error.log  (ver logs nginx)"
echo ""
echo -e "${GREEN}🎉 Servidor listo para recibir la aplicación!${NC}"