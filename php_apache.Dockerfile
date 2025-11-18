FROM php:8.4-apache

#modulo apache para transformar url`s
RUN a2enmod rewrite

# debug
RUN pecl install xdebug-3.4.5 && docker-php-ext-enable xdebug