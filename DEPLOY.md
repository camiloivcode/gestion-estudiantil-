# Deploy — EduPlatform

## Requisitos

- Docker + Docker Compose
- Acceso a MySQL 8.0
- Redis 7.x (recomendado)

## Variables de entorno (producción)

```bash
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:...  # Generar con: php artisan key:generate
APP_URL=https://tu-dominio.com

DB_HOST=...
DB_PORT=3306
DB_DATABASE=eduplatform
DB_USERNAME=...
DB_PASSWORD=...

REDIS_HOST=...
REDIS_PASSWORD=...
REDIS_PORT=6379

CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

LOG_CHANNEL=stdout
LOG_LEVEL=warning

MAIL_MAILER=smtp
MAIL_HOST=...
MAIL_PORT=587
MAIL_USERNAME=...
MAIL_PASSWORD=...
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@tu-dominio.com
```

## Despliegue con Docker Compose (producción)

```bash
# 1. Clonar y configurar
git clone <repo>
cd gestion-estudiantil
cp .env.example .env
# Editar .env con tus valores

# 2. Generar APP_KEY
docker compose run --rm app php artisan key:generate

# 3. Iniciar servicios
docker compose -f docker-compose.prod.yml up -d

# 4. Migrar y seedear (primera vez)
docker compose -f docker-compose.prod.yml exec app php artisan migrate --seed
```

## Despliegue en plataforma cloud (Railway / Render / Fly.io)

### Railway
```bash
# Conectar repo → Railway detecta el Dockerfile automáticamente
# Configurar variables de entorno desde el dashboard
# Agregar MySQL + Redis como plugins
```

### Render
```bash
# Crear Web Service → Dockerfile
# Crear MySQL + Redis como add-ons
# Configurar healthcheck path: /health
# Agregar un segundo servicio "queue" con:
#   - Dockerfile: docker/php/Dockerfile
#   - Start command: php artisan queue:work redis --sleep=3 --tries=3
```

### Fly.io
```bash
# fly launch --dockerfile docker/php/Dockerfile
# fly postgres create (o mysql)
# fly redis create
# fly secrets set APP_KEY=... DB_PASSWORD=...
# fly deploy
```

## Post-despliegue

```bash
# Verificar health
curl https://tu-dominio.com/health

# Cache de config
docker compose exec app php artisan config:cache
docker compose exec app php artisan route:cache
docker compose exec app php artisan view:cache

# Storage link
docker compose exec app php artisan storage:link

# Crear admin
docker compose exec app php artisan tinker --execute="
    \App\Models\User::create([
        'name' => 'Admin',
        'email' => 'admin@tudominio.com',
        'password' => bcrypt('tu-password-segura'),
        'role' => 'admin',
    ]);
"
```

## Mantenimiento

```bash
# Logs
docker compose logs -f app nginx queue

# Backup DB
docker compose exec mysql mysqldump -u root -p eduplatform > backup.sql

# Actualizar
git pull
docker compose up -d --build
docker compose exec app php artisan migrate --force
```
