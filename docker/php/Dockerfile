FROM php:8.2.0-fpm

WORKDIR /app/api

#RUN apt-get update && apt-get install -y \
#        git \
#        curl \
#        zip \
#        unzip

RUN apt-get update && \
    apt-get install -y --no-install-recommends libssl-dev zlib1g-dev curl git unzip netcat libxml2-dev libpq-dev libzip-dev && \
    pecl install apcu && \
    docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
    docker-php-ext-install -j$(nproc) zip opcache intl pdo_pgsql pgsql && \
    docker-php-ext-enable apcu pdo_pgsql sodium && \
    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*



#        docker-php-ext-install pdo_mysql && \



RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash

#RUN sudo composer update
RUN mkdir -p -m 777 /tmp/composer
ENV COMPOSER_HOME=/tmp/composer

COPY docker/php/xdebug.ini "${PHP_INI_DIR}/conf.d"


EXPOSE 9000

