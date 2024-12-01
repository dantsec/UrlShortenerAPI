FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git \
    libssl-dev libonig-dev libpq-dev \
    && docker-php-ext-install -j$(nproc) \
        pdo pdo_mysql \
        mbstring \
        opcache

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . /app

RUN composer update \
    && composer install --optimize-autoloader \
    && composer dump-autoload

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
