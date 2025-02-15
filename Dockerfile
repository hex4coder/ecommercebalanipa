# Gunakan image base Ubuntu
FROM ubuntu:latest

# Install paket-paket yang dibutuhkan
RUN apt-get update && \
    apt-get install -y \
    build-essential \
    libpng-dev \
    locales \
    zip \
    unzip \
    git \
    php \
    php-cli \
    php-fpm \
    php-mysql \
    php-zip \
    php-gd \
    php-curl \
    wget \
    curl \
    php-xml \
    php-mbstring \
    php-intl
    

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install FrankenPHP (perubahan di sini)
RUN apt-get install -y \
    caddy

RUN curl https://frankenphp.dev/install.sh | sh
RUN mv frankenphp /usr/local/bin/

# Set working directory di dalam container
WORKDIR /var/www/html

# Copy file composer.json dan composer.lock (jika ada)
COPY composer.json composer.lock ./

# Copy source code aplikasi Laravel
COPY . .

# Install dependencies Composer
RUN composer install --no-interaction --no-dev --optimize-autoloader

# install laravel octane
RUN composer require laravel/octane

# Konfigurasi Caddy untuk Laravel (perubahan di sini)
COPY Caddyfile /etc/caddy/Caddyfile

# Jalankan perintah-perintah yang dibutuhkan Laravel
RUN chown -R www-data:www-data /var/www/html \
&& chmod -R 755 /var/www/html \
&& chmod +x artisan \
&& php artisan key:generate --force \
&& php artisan config:cache \
&& php artisan route:cache


RUN php artisan octane:install --server=frankenphp

# Expose port 8000 untuk web server Caddy (FrankenPHP)
EXPOSE 8000

# Jalankan Caddy (FrankenPHP)
# CMD ["caddy", "run", "--config", "/etc/caddy/Caddyfile"]
# CMD [ "frankenphp", "php-server" ]
#  php artisan migrate
CMD [ "php", "artisan", "migrate", " && " "php", "artisan", "octane:frankenphp", "--host=0.0.0.0" ]