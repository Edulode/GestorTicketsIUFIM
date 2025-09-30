# 👥 Usuarios del Sistema de Tickets

## 🔑 Credenciales de Acceso Predeterminadas

### Administradores
| Usuario | Email | Contraseña | Descripción |
|---------|-------|------------|-------------|
| **Administrador** | `admin@iufim.edu.mx` | `admin123` | Usuario principal con acceso completo |
| **Coordinador IT** | `coordinador@iufim.edu.mx` | `coord123` | Coordinador del departamento de IT |
| **Director IT** | `director@iufim.edu.mx` | `director123` | Director del departamento |

### Soporte Técnico
| Usuario | Email | Contraseña | Descripción |
|---------|-------|------------|-------------|
| **Soporte Técnico** | `soporte@iufim.edu.mx` | `soporte123` | Personal de soporte técnico |

### Usuario de Prueba
| Usuario | Email | Contraseña | Descripción |
|---------|-------|------------|-------------|
| **Usuario Demo** | `demo@iufim.edu.mx` | `demo123` | Usuario para pruebas y demostraciones |

## 🛠️ Comandos para Gestión de Usuarios

### Crear un nuevo usuario
```bash
php artisan user:create
```

### Crear usuario con parámetros específicos
```bash
php artisan user:create --name="Nombre Usuario" --email="usuario@iufim.edu.mx" --password="contraseña123"
```

### Listar todos los usuarios
```bash
php artisan user:list
```

### Ejecutar todos los seeders (incluyendo usuarios)
```bash
php artisan db:seed
```

### Ejecutar solo el seeder de usuarios
```bash
php artisan db:seed --class=UserSeeder
```

## 🔐 Acceso al Sistema

1. **Página de Login**: `/login`
2. **Página Principal**: `/dashboard` (redirige a la lista de tickets)
3. **Crear Ticket**: `/` o `/tickets/create`
4. **Lista de Tickets**: `/mis-tickets`

## 📝 Notas Importantes

- Todos los usuarios están **pre-verificados** (email_verified_at está configurado)
- Las contraseñas están **hasheadas** usando bcrypt
- Los usuarios pueden cambiar sus contraseñas desde el perfil
- Se puede acceder a la gestión de perfil en `/profile`

## 🔄 Restablecer Usuarios

Si necesitas restablecer todos los usuarios:

```bash
# Eliminar todos los usuarios
php artisan tinker --execute="App\Models\User::truncate();"

# Volver a crear los usuarios predeterminados
php artisan db:seed --class=UserSeeder
```