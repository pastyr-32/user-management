FROM php:fpm

RUN apt-get update \
    && docker-php-ext-install pdo_mysql