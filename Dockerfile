FROM php:7.4.28-apache

RUN apt-get update

RUN apt-get install -fyqq \
    zip \
    unzip

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/
RUN install-php-extensions zip

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
