all: config/config.php vendor

config/config.php:
	cp config/config.default.php config/config.php

vendor:
	composer install

migration: config/config.php vendor
	vendor/bin/phinx migrate

tests: migration
	vendor/bin/phpunit --bootstrap vendor/autoload.php tests/

.PHONY: all migration tests
