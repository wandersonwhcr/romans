FROM php:7.4-cli-alpine

ENV COMPOSER_CACHE_DIR /tmp

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir /usr/bin --filename composer \
    && php -r "unlink('composer-setup.php');" \
    && docker-php-source delete \
    && apk add unzip

VOLUME /app

WORKDIR /app
