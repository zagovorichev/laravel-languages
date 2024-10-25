FROM php:8.3-fpm

RUN apt-get update && apt-get install -y libicu-dev zlib1g-dev libzip-dev zip \
    && docker-php-ext-configure intl \
    && pecl install xdebug \
    && docker-php-ext-install zip intl \
    && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN { \
    echo 'memory_limit=512M'; \
} >> /usr/local/etc/php/conf.d/docker-php-ext-memory-limit.ini

RUN rm -rf /var/www/html \
    && chmod 0777 /tmp/
