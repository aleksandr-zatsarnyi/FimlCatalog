FROM php:apache

# Установка дополнительных пакетов и расширений PHP
RUN apt-get update && \
    apt-get install -y \
    git \
    libzip-dev

#xdebug
ARG INSTALL_XDEBUG=false
RUN if [ ${INSTALL_XDEBUG} = true ]; \
    then \
      pecl install xdebug && docker-php-ext-enable xdebug; \
    fi;

COPY ./docker/webserver/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN docker-php-ext-install mysqli && \
    docker-php-ext-enable mysqli

RUN docker-php-ext-install pdo_mysql && \
    docker-php-ext-enable pdo_mysql

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Source code
RUN chown www-data:www-data /var/www
COPY --chown=www-data:www-data ./ /var/www
WORKDIR /var/www

