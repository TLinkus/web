#!/usr/bin/env bash
set -e

cd /var/www/html

if [ ! -d vendor ]; then
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

mkdir -p writable/cache writable/debugbar writable/logs writable/session writable/uploads
chown -R www-data:www-data writable

exec "$@"
