ARG PHP_VERSION

FROM php:${PHP_VERSION}-cli-alpine

ENV COMPOSER_CACHE_DIR /tmp

COPY --from=composer:2.3 /usr/bin/composer /usr/local/bin/composer

RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install pcov \
    && docker-php-ext-enable pcov \
    && apk del $PHPIZE_DEPS \
    && find /usr/src -type f -name 'php.tar*' -delete \
    && apk add --no-cache unzip

VOLUME /app

WORKDIR /app
