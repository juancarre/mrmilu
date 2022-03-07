FROM php:7.4.6-apache

COPY ./php.ini /usr/local/etc/php/php.ini

RUN apt-get update \
    && apt-get install -y git acl openssl openssh-client wget zip vim librabbitmq-dev libssh-dev \
    && apt-get install -y libpng-dev zlib1g-dev libzip-dev libxml2-dev libicu-dev \
    && docker-php-ext-install intl pdo pdo_mysql zip gd soap bcmath sockets \
    && pecl install amqp \
    && docker-php-ext-enable --ini-name 05-opcache.ini opcache amqp

RUN curl --insecure https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer
RUN composer self-update

WORKDIR /app

COPY api/composer.* ./
RUN composer install --no-dev
COPY api/* ./
RUN bin/console assets:install