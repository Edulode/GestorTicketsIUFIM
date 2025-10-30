#!/bin/bash

# 🚀 Script de Deploy Automatizado para VPS
# Gestor de Tickets IUFIM

set -e  # Salir si hay errores

# Colores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Configuración (EDITAR ESTOS VALORES)
SERVER_USER="root"
SERVER_IP="TU_SERVIDOR_IP"
SERVER_PATH="/var/www/GestorTicketsIUFIM"
APP_URL="https://tu-dominio.com"
DB_NAME="gestorticketsiufim"
DB_USER="tickets_user"
DB_PASS="password_seguro_2024"

echo -e "${BLUE}🚀 INICIANDO DEPLOY REMOTO - GESTOR TICKETS IUFIM${NC}"
echo "=================================================="

# Verificar conexión SSH
echo -e "${YELLOW}🔍 Verificando conexión SSH...${NC}"
if ssh -o ConnectTimeout=10 -o BatchMode=yes $SERVER_USER@$SERVER_IP exit 2>/dev/null; then
    echo -e "${GREEN}✅ Conexión SSH exitosa${NC}"
else
    echo -e "${RED}❌ Error: No se puede conectar al servidor${NC}"
    echo "Verificar IP, usuario y configuración SSH"
    exit 1
fi

# Preparar archivos localmente
echo -e "${YELLOW}📦 Preparando archivos localmente...${NC}"
if [ ! -f "composer.json" ]; then
    echo -e "${RED}❌ Error: No se encuentra composer.json${NC}"
    echo "Ejecutar desde el directorio raíz del proyecto"
    exit 1
fi

# Instalar dependencias localmente para optimizar
echo -e "${YELLOW}⚙️ Optimizando dependencias localmente...${NC}"
composer install --optimize-autoloader --no-dev --quiet

# Compilar assets si Node.js está disponible
if command -v npm &> /dev/null; then
    echo -e "${YELLOW}🎨 Compilando assets...${NC}"
    npm install --silent
    npm run build --silent
else
    echo -e "${YELLOW}⚠️ Node.js no encontrado, saltando compilación de assets${NC}"
fi

# Crear directorio temporal para archivos
TEMP_DIR=$(mktemp -d)
echo -e "${YELLOW}📁 Creando paquete de archivos...${NC}"

# Copiar archivos necesarios
rsync -a --exclude='node_modules' \
         --exclude='.git' \
         --exclude='tests' \
         --exclude='storage/logs/*' \
         --exclude='storage/app/public/*' \
         --exclude='.env' \
         ./ $TEMP_DIR/

# Subir archivos al servidor
echo -e "${YELLOW}📤 Subiendo archivos al servidor...${NC}"
ssh $SERVER_USER@$SERVER_IP "mkdir -p $SERVER_PATH"
rsync -avz --progress $TEMP_DIR/ $SERVER_USER@$SERVER_IP:$SERVER_PATH/

# Limpiar directorio temporal
rm -rf $TEMP_DIR

# Configurar en el servidor
echo -e "${YELLOW}⚙️ Configurando aplicación en servidor...${NC}"
ssh $SERVER_USER@$SERVER_IP << EOF
set -e

echo "🔧 Configurando permisos..."
cd $SERVER_PATH
chown -R www-data:www-data .
chmod -R 755 .
chmod -R 775 storage bootstrap/cache

echo "📝 Configurando .env..."
if [ ! -f .env ]; then
    cp .env.example .env
    
    # Configurar variables básicas
    sed -i 's/APP_ENV=local/APP_ENV=production/' .env
    sed -i 's/APP_DEBUG=true/APP_DEBUG=false/' .env
    sed -i "s|APP_URL=.*|APP_URL=$APP_URL|" .env
    
    # Configurar base de datos
    sed -i "s/DB_DATABASE=.*/DB_DATABASE=$DB_NAME/" .env
    sed -i "s/DB_USERNAME=.*/DB_USERNAME=$DB_USER/" .env
    sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=$DB_PASS/" .env
    
    echo "✅ Archivo .env configurado"
fi

echo "🔑 Generando clave de aplicación..."
php artisan key:generate --force

echo "📊 Ejecutando migraciones..."
php artisan migrate --force

echo "🌱 Cargando datos iniciales..."
php artisan db:seed --force

echo "🔗 Creando enlaces simbólicos..."
php artisan storage:link

echo "⚡ Optimizando para producción..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "🔄 Reiniciando servicios..."
systemctl reload nginx
systemctl reload php8.2-fpm

echo "✅ Configuración completada en servidor"
EOF

# Verificar que la aplicación esté funcionando
echo -e "${YELLOW}🔍 Verificando aplicación...${NC}"
if curl -s -o /dev/null -w "%{http_code}" $APP_URL | grep -q "200"; then
    echo -e "${GREEN}✅ Aplicación funcionando correctamente en $APP_URL${NC}"
else
    echo -e "${YELLOW}⚠️ Verificar manualmente: $APP_URL${NC}"
fi

# Crear backup después del deploy
echo -e "${YELLOW}💾 Creando backup post-deploy...${NC}"
ssh $SERVER_USER@$SERVER_IP << 'EOF'
cd /var/www/GestorTicketsIUFIM
DATE=$(date +%Y%m%d_%H%M%S)
mkdir -p backups
mysqldump -u tickets_user -p'password_seguro_2024' gestorticketsiufim > backups/post_deploy_$DATE.sql
echo "✅ Backup creado: backups/post_deploy_$DATE.sql"
EOF

echo ""
echo -e "${GREEN}🎉 DEPLOY COMPLETADO EXITOSAMENTE${NC}"
echo "=================================================="
echo -e "🌐 URL: ${BLUE}$APP_URL${NC}"
echo -e "🗂️ Ruta servidor: ${BLUE}$SERVER_PATH${NC}"
echo -e "💾 Backup: ${BLUE}post_deploy_$(date +%Y%m%d_%H%M%S).sql${NC}"
echo ""
echo -e "${YELLOW}📋 Próximos pasos:${NC}"
echo "1. Verificar funcionamiento en $APP_URL"
echo "2. Crear usuario administrador si es necesario"
echo "3. Configurar certificado SSL si no está activo"
echo "4. Programar backups automáticos"
echo ""