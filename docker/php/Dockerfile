FROM php:7.4-fpm-alpine
RUN apk add -U --no-cache \
    bash \
    git \
    curl-dev \
    libxml2-dev \
    postgresql-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    zip \
    libzip-dev \
    unzip \
    gmp-dev \
    oniguruma-dev \
    sqlite-libs \
    sqlite-dev
RUN docker-php-ext-install pdo_mysql mysqli mbstring
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

WORKDIR /usr/share/nginx/html/