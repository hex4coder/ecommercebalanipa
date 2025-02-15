# Gunakan image base FrankenPHP
FROM dunglas/frankenphp:latest

# Install ekstensi yang dibutuhkan Laravel (opsional, jika ada)
RUN apk update && \
    apk add -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    unzip \
    git

# Install Composer (perubahan di sini)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory di dalam container
WORKDIR /var/www/html

# Copy file composer.json dan composer.lock (jika ada)
COPY composer.json composer.lock ./

# Install dependencies Composer
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Copy source code aplikasi Laravel
COPY . .

# Jalankan perintah-perintah yang dibutuhkan Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && php artisan key:generate --force \
    && php artisan config:cache \
    && php artisan route:cache

# Expose port 80 untuk web server Caddy (FrankenPHP)
EXPOSE 80

# FrankenPHP sudah berjalan secara default, jadi tidak perlu CMD