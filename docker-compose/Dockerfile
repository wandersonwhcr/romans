FROM php:8.0-cli-alpine

ENV COMPOSER_CACHE_DIR /tmp

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir /usr/bin --filename composer \
    && php -r "unlink('composer-setup.php');" \
    && find /usr/src -type f -name 'php.tar*' -delete \
    && apk add unzip

VOLUME /app

WORKDIR /app
