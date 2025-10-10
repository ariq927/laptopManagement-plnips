FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

# Enable Apache mod_rewrite untuk Laravel routes
RUN a2enmod rewrite

# Install Node.js (untuk npm build)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . /var/www/html

# Buat directories untuk storage (kalau belum ada)
RUN mkdir -p storage/framework/views storage/framework/cache storage/app storage/logs bootstrap/cache

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev --no-scripts

# Install dan build assets (kalau ada Vite/Mix)
RUN npm install && npm run build

# Set permissions (www-data untuk Apache)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Set Apache document root ke Laravel's public folder
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Expose port (Railway akan override dengan $PORT)
EXPOSE ${PORT:-8080}

# Copy custom entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Gunakan entrypoint script untuk handle migrasi dan start
ENTRYPOINT ["docker-entrypoint.sh"]

# Default CMD (Apache start, fallback kalau entrypoint gak override)
CMD ["apache2-foreground"]