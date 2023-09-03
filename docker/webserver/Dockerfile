FROM php:apache

RUN apt-get update && \
    apt-get install -y \
    git \
    libzip-dev

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

ARG PUID=1000
ARG PGID=1000
RUN groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data www-data

# Source code
RUN chown www-data:www-data /var/www
COPY --chown=www-data:www-data ./ /var/www
WORKDIR /var/www

USER www-data

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
#RUN composer install

