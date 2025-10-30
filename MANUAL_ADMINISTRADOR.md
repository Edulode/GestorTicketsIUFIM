# 🔧 Manual del Administrador del Sistema - Gestor Tickets IUFIM

## 📋 **Información del Sistema**

### **URLs de Acceso**
- **Servidor Local:** `http://192.168.100.6:8000`
- **Panel de Administración:** `http://192.168.100.6:8000/admin`
- **Reportes:** `http://192.168.100.6:8000/reportes`

### **Credenciales Predeterminadas**
```
Email: admin@iufim.local
Password: [Configurado durante instalación]
```

---

## 🚀 **Inicio Rápido**

### **Encender el Sistema**
1. Hacer doble clic en `iniciar_servidor_red.bat`
2. Esperar mensaje: "Laravel development server started"
3. Compartir URL con usuarios: `http://192.168.100.6:8000`

### **Apagar el Sistema**
- Presionar `Ctrl+C` en la ventana del servidor
- Cerrar ventana de comandos

---

## 👥 **Gestión de Usuarios**

### **Crear Nuevo Usuario**
```bash
# Método 1: Via web (recomendado)
# Ir a http://192.168.100.6:8000/admin/usuarios/create

# Método 2: Via comando
php artisan tinker
```
```php
$user = new App\Models\User();
$user->name = 'Nombre Usuario';
$user->email = 'usuario@iufim.local';
$user->password = Hash::make('password_temporal');
$user->save();
```

### **Resetear Password de Usuario**
```bash
php artisan tinker
```
```php
$user = App\Models\User::where('email', 'usuario@email.com')->first();
$user->password = Hash::make('nueva_password');
$user->save();
echo 'Password actualizada';
```

### **Listar Todos los Usuarios**
```bash
php artisan tinker --execute="App\Models\User::all(['id', 'name', 'email', 'created_at'])->each(function($u) { echo $u->id . ' - ' . $u->name . ' (' . $u->email . ') - ' . $u->created_at . PHP_EOL; });"
```

---

## 🎫 **Gestión de Tickets**

### **Estadísticas Rápidas**
```bash
# Ver resumen de tickets
php artisan tinker --execute="
echo 'ESTADÍSTICAS DE TICKETS:' . PHP_EOL;
echo 'Total: ' . App\Models\Ticket::count() . PHP_EOL;
echo 'Pendientes: ' . App\Models\Ticket::whereHas('status', function($q) { $q->where('status', 'Pendiente'); })->count() . PHP_EOL;
echo 'En Proceso: ' . App\Models\Ticket::whereHas('status', function($q) { $q->where('status', 'En Proceso'); })->count() . PHP_EOL;
echo 'Resueltos: ' . App\Models\Ticket::whereHas('status', function($q) { $q->where('status', 'Resuelto'); })->count() . PHP_EOL;
"
```

### **Tickets Sin Asignar**
```bash
php artisan tinker --execute="
App\Models\Ticket::whereNull('tecnico_id')->get(['id', 'asunto', 'created_at'])->each(function($t) {
    echo 'ID: ' . $t->id . ' - ' . $t->asunto . ' (' . $t->created_at->format('d/m/Y') . ')' . PHP_EOL;
});
"
```

---

## 📊 **Base de Datos**

### **Backup Manual**
```bash
# Ejecutar script de backup
crear_backup.bat

# O comando manual
mysqldump -u root -p gestorticketsiufim > backup_manual.sql
```

### **Restaurar Backup**
```bash
# Para SQLite
copy backup_database.sqlite database\database.sqlite

# Para MySQL
mysql -u root -p gestorticketsiufim < backup_manual.sql
```

### **Limpiar Base de Datos (CUIDADO)**
```bash
# Recrear todas las tablas (ELIMINA TODOS LOS DATOS)
php artisan migrate:fresh --seed

# Solo limpiar cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## 🏷️ **Gestión de Categorías y Tipos**

### **Agregar Nueva Categoría**
```bash
# Via web: http://192.168.100.6:8000/categorias-servicio/create

# Via comando
php artisan tinker
```
```php
$categoria = new App\Models\CategoriaServicio();
$categoria->categoria_servicio = 'Nueva Categoría';
$categoria->save();
```

### **Agregar Tipo de Solicitud**
```php
$tipo = new App\Models\TipoSolicitud();
$tipo->tipo_solicitud = 'Nuevo Tipo';
$tipo->categoria_servicio_id = 1; // ID de la categoría
$tipo->save();
```

### **Ver Relaciones**
```bash
php artisan tinker --execute="
App\Models\CategoriaServicio::with('tiposSolicitud')->get()->each(function($cat) {
    echo $cat->categoria_servicio . ':' . PHP_EOL;
    $cat->tiposSolicitud->each(function($tipo) {
        echo '  - ' . $tipo->tipo_solicitud . PHP_EOL;
    });
    echo PHP_EOL;
});
"
```

---

## 🔧 **Mantenimiento del Sistema**

### **Optimización Periódica**
```bash
# Ejecutar semanalmente
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan queue:work --stop-when-empty
```

### **Limpiar Logs Antiguos**
```bash
# Limpiar logs mayores a 30 días
forfiles /p storage\logs /m *.log /d -30 /c "cmd /c del @path"
```

### **Verificar Salud del Sistema**
```bash
# Verificar conexión DB
php artisan tinker --execute="try { DB::connection()->getPdo(); echo 'Database: OK'; } catch(Exception $e) { echo 'Database: ERROR - ' . $e->getMessage(); }"

# Verificar espacio en disco
dir /-c storage

# Verificar procesos PHP activos
tasklist | findstr php
```

---

## 🌐 **Configuración de Red**

### **Cambiar IP del Servidor**
1. Editar archivo `.env`
2. Cambiar línea: `APP_URL=http://NUEVA_IP:8000`
3. Reiniciar servidor

### **Cambiar Puerto**
```bash
# Iniciar en puerto diferente
php artisan serve --host=0.0.0.0 --port=8080
```

### **Verificar Conectividad desde Cliente**
```bash
# Desde otro equipo, probar:
ping 192.168.100.6
telnet 192.168.100.6 8000
```

### **Abrir Puerto en Firewall**
```cmd
# Windows
netsh advfirewall firewall add rule name="Tickets IUFIM" dir=in action=allow protocol=TCP localport=8000

# Verificar puertos abiertos
netstat -an | findstr :8000
```

---

## 📧 **Configuración de Email**

### **Gmail SMTP**
```env
# En archivo .env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@gmail.com
MAIL_PASSWORD=tu_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tickets@iufim.local
MAIL_FROM_NAME="Gestor Tickets IUFIM"
```

### **Probar Email**
```bash
php artisan tinker
```
```php
Mail::raw('Prueba de email desde el sistema', function($message) {
    $message->to('admin@iufim.local')->subject('Test Email');
});
```

---

## 🚨 **Resolución de Problemas**

### **El servidor no inicia**
```bash
# Verificar puerto ocupado
netstat -an | findstr :8000

# Cambiar puerto si está ocupado
php artisan serve --host=0.0.0.0 --port=8001
```

### **Error de base de datos**
```bash
# Verificar configuración
php artisan config:show database

# Recrear migraciones
php artisan migrate:fresh --seed
```

### **Los usuarios no pueden acceder**
1. Verificar firewall de Windows
2. Verificar antivirus no bloquee puerto
3. Verificar IP del servidor: `ipconfig`
4. Probar acceso local: `http://localhost:8000`

### **Páginas se ven sin estilos**
```bash
# Recompilar assets
npm run build

# Limpiar cache de vistas
php artisan view:clear

# Verificar permisos
icacls public /grant Users:F /T
```

### **Error 500 Internal Server Error**
```bash
# Ver logs detallados
tail -f storage/logs/laravel.log

# Verificar permisos de storage
icacls storage /grant Users:F /T
icacls bootstrap\cache /grant Users:F /T
```

---

## 📈 **Monitoreo y Estadísticas**

### **Uso del Sistema (semanal)**
```bash
php artisan tinker --execute="
echo 'REPORTE SEMANAL:' . PHP_EOL;
echo 'Tickets creados esta semana: ' . App\Models\Ticket::where('created_at', '>=', now()->subWeek())->count() . PHP_EOL;
echo 'Usuarios activos: ' . App\Models\User::where('updated_at', '>=', now()->subWeek())->count() . PHP_EOL;
echo 'Tickets resueltos: ' . App\Models\Ticket::whereHas('status', function($q) { $q->where('status', 'Resuelto'); })->where('updated_at', '>=', now()->subWeek())->count() . PHP_EOL;
"
```

### **Logs de Acceso**
```bash
# Ver últimos accesos
findstr "GET" storage\logs\laravel.log | tail -10

# Contar accesos por día
findstr "$(date /t)" storage\logs\laravel.log | find /c "GET"
```

---

## 🔐 **Seguridad**

### **Cambiar Clave de Aplicación**
```bash
php artisan key:generate
```

### **Configurar HTTPS (Opcional)**
```env
# En .env
APP_URL=https://192.168.100.6:8000
SESSION_SECURE_COOKIE=true
```

### **Backup de Seguridad**
```bash
# Programar backup diario
# Usar Programador de tareas de Windows
# Ejecutar crear_backup.bat diariamente a las 2:00 AM
```

---

## 📞 **Contacto y Soporte**

### **Información del Sistema**
- **Versión Laravel:** 11.x
- **PHP:** 8.1+
- **Base de Datos:** MySQL/SQLite
- **Puerto:** 8000

### **Archivos Importantes**
- **Configuración:** `.env`
- **Logs:** `storage/logs/laravel.log`
- **Base de datos SQLite:** `database/database.sqlite`
- **Uploads:** `storage/app/public/`

### **Scripts de Utilidad**
- **`configurar_sistema.bat`** - Configuración inicial
- **`iniciar_servidor_red.bat`** - Iniciar servidor
- **`crear_backup.bat`** - Crear respaldo

---

**📋 Recordatorio:** 
- Crear backup antes de actualizaciones
- Monitorear espacio en disco
- Verificar conectividad de red regularmente
- Mantener credenciales seguras
- Documentar cambios importantes