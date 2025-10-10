#!/bin/bash
set -e

PORT=${PORT:-8080}

echo "Starting Apache on port $PORT"

sed -i "s/Listen 80/Listen $PORT/g" /etc/apache2/ports.conf
sed -i "s/:80/:$PORT/g" /etc/apache2/sites-available/000-default.conf

php artisan migrate --force

apache2-foreground