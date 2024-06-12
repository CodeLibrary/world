# syntax=docker/dockerfile:1

FROM php:8.3-fpm

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN apt-get update && apt-get install -y unzip git libmemcached-dev libssl-dev zlib1g-dev \
    && docker-php-ext-install gettext \
    && pecl install xdebug && docker-php-ext-enable xdebug \
    && echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer

COPY . /var/www/html

RUN usermod  -u 1000 www-data \
    && groupmod -g 1000 www-data \
    && chown -R www-data:www-data /var/www/

USER www-data
