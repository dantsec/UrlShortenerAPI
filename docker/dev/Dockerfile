FROM php:8.3-fpm-alpine

WORKDIR /app

RUN apk update && apk add build-base

RUN apk add \
    oniguruma-dev \
    zlib-dev git zip \
    openssl-dev \
    libpq-dev libzip-dev

RUN docker-php-ext-configure zip

RUN docker-php-ext-install -j$(nproc) \
    pdo pdo_mysql mbstring opcache zip

RUN curl -sS https://getcomposer.org/installer | php \
        && mv composer.phar /usr/local/bin/ \
        && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer

COPY . /app

RUN composer install --prefer-source --no-interaction

RUN composer dump-autoload

ENV PATH="~/.composer/vendor/bin:./vendor/bin:${PATH}"

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
