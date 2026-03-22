FROM php:8.3-cli

# Instalar extensiones necesarias
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Directorio de trabajo
WORKDIR /var/www

# Copiar archivos del proyecto
COPY . .

# Instalar dependencias de Laravel
RUN composer install --optimize-autoloader --no-dev

# Permisos
RUN chmod -R 775 storage bootstrap/cache

# Exponer puerto
EXPOSE 10000

# Arrancar Laravel
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000