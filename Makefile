# Silent 'make' recipes by-default
MAKEFLAGS += --silent

docker-build:
	docker build --rm -f Dockerfile -t waseem/intercom:1.0 .

docker-run:
	docker run --rm --name=waseem_intercom -it waseem/intercom:1.0

setup:
	sudo apt update
	sudo apt install -y wget zip unzip php7.2-cli php7.2-xml
	wget https://getcomposer.org/download/1.6.4/composer.phar
	php -f composer.phar install --no-dev

run:
	php -f index.php ${ARGS}

test:
	./vendor/phpunit/phpunit/phpunit --coverage-text='asset/code-coverage-report.txt' --whitelist='src/' tests/
	cat asset/code-coverage-report.txt

# Devs
dev-setup: setup
	sudo apt install -y php-xdebug php7.2-mbstring
	wget https://github.com/FriendsOfPHP/PHP-CS-Fixer/releases/download/v2.12.1/php-cs-fixer.phar -O php-cs-fixer
	chmod a+x php-cs-fixer
	php -f composer.phar install

dev-build:
	php php-cs-fixer fix src/
