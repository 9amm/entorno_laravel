FROM php:8.4-apache

#modulo apache para transformar url`s
RUN a2enmod rewrite


WORKDIR /var/www/proyecto

#instalar dependencias composer
RUN apt update -y \
    && apt install wget -y\
    && apt install unzip -y\
    && apt install git -y

#instalar composer
COPY --from=composer:2.9.1 /usr/bin/composer /usr/bin/composer

#copiar todo el codigo del proyecto en la imagen
COPY ./proyecto /var/www/proyecto/

#cambiar el propietario a www-data
RUN chown -R www-data /var/www/proyecto/

#instalar doxygen para generar documentacion
RUN apt install -y doxygen && apt install -y graphviz


# debug
RUN pecl install xdebug-3.4.5 && docker-php-ext-enable xdebug