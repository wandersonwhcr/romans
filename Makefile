COMPOSER_FLAGS = --prefer-dist

all: install

.PHONY: install
install:
	composer install ${COMPOSER_FLAGS}

.PHONY: optimize
optimize: COMPOSER_FLAGS = --no-dev --optimize-autoloader --classmap-authoritative
optimize: install

.PHONY: test
test:
	php vendor/bin/parallel-lint src
	php vendor/bin/phpunit
	php vendor/bin/phpcpd src
	php vendor/bin/phpmd src text phpmd.xml
	php vendor/bin/phpcs
