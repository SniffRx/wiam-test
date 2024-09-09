FROM php:8.2-fpm

# Установить необходимые пакеты
RUN apt-get update && \
    apt-get install -y \
        libpq-dev \
        git \
        unzip \
    && rm -rf /var/lib/apt/lists/*

# Установить необходимые расширения PHP
RUN docker-php-ext-install pdo pdo_pgsql

# Установить Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Установить рабочую директорию
WORKDIR /var/www/html

# Копировать настройки PHP
COPY php.ini /usr/local/etc/php/
