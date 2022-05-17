FROM php:7.4.28-apache

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
