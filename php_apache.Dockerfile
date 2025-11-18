FROM php:8.4-apache

#modulo apache para transformar url`s
RUN a2enmod rewrite


WORKDIR /var/www/proyecto

#instalar composer
RUN apt update -y \
    && apt install wget \
    && apt install unzip \
    && wget https://raw.githubusercontent.com/composer/getcomposer.org/f3108f64b4e1c1ce6eb462b159956461592b3e3e/web/installer -O - -q | php -- --quiet


# debug
RUN pecl install xdebug-3.4.5 && docker-php-ext-enable xdebug