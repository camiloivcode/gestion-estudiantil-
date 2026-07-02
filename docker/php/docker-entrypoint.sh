#!/bin/sh
set -e

# Esperar a que MySQL esté listo (usado en producción)
if [ -n "$DB_HOST" ]; then
    echo "⏳  Esperando a MySQL ($DB_HOST:$DB_PORT)..."
    for i in $(seq 1 30); do
        if php -r "try { new PDO('mysql:host=$DB_HOST;port=$DB_PORT', '$DB_USERNAME', '$DB_PASSWORD'); echo 'ok'; } catch(Exception \$e) {}" 2>/dev/null | grep -q ok; then
            echo "✅  MySQL listo"
            break
        fi
        sleep 1
    done
fi

# Generar APP_KEY si está vacío
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:" ]; then
    echo "🔑  Generando APP_KEY..."
    php artisan key:generate --force
fi

# Cache de configuración (solo en producción)
if [ "$APP_ENV" = "production" ]; then
    echo "⚡  Optimizando para producción..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    php artisan event:cache
fi

# Migrar (solo si no se ha migrado)
php artisan migrate --force

# Storage link
if [ ! -L public/storage ]; then
    php artisan storage:link --force
fi

echo "🚀  Iniciando PHP-FPM..."
exec php-fpm
