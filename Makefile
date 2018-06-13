run:
	php -f index.php

test:
	./vendor/phpunit/phpunit/phpunit --coverage-text='asset/code-coverage-report.txt' --whitelist='src/' tests/

install:
	php -f composer.phar install --no-dev

dev-install:
	php -f composer.phar install

dev-update:
	php -f composer.phar update

build:
	php php-cs-fixer fix src/

get-composer:
	wget https://getcomposer.org/download/1.6.4/composer.phar

get-cs-fixer:
	wget https://github.com/FriendsOfPHP/PHP-CS-Fixer/releases/download/v2.12.1/php-cs-fixer.phar -O php-cs-fixer
	chmod a+x php-cs-fixer
