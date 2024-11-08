# Usa l'immagine ufficiale PHP
FROM php:8.1-fpm

# Installa le dipendenze di sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm

# Installa le estensioni PHP richieste
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Installa Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Installa PHPUnit
RUN curl -L https://phar.phpunit.de/phpunit-9.5.phar -o /usr/local/bin/phpunit && \
    chmod +x /usr/local/bin/phpunit

# Imposta la directory di lavoro
WORKDIR /var/www

# Copia i file di configurazione locali nel container
COPY . .

# Imposta i permessi per le cartelle necessarie
RUN chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
ENTRYPOINT ["docker-entrypoint.sh"]

# Pulisce la cache di Laravel
RUN php artisan cache:clear || true
RUN php artisan config:clear || true
RUN php artisan route:clear || true
RUN php artisan view:clear || true

# Genera la chiave di applicazione (opzionale)
RUN php artisan key:generate

# Espone la porta
EXPOSE 9000

# Avvia PHP-FPM
CMD ["php-fpm"]
