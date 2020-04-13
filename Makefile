install:
	docker-compose build --pull --no-cache
	docker-compose up -d

start:
	docker-compose up -d

restart:
	docker-compose down
	docker-compose up -d

bash:
	docker-compose exec php sh

phpunit:
	docker-compose exec php vendor/bin/simple-phpunit --configuration phpunit.xml.dist

phpcs:
	docker-compose exec php vendor/bin/php-cs-fixer fix

fixture:
	docker-compose exec php bin/console hautelook:fixtures:load --env=test

version:
	docker-compose exec php php --version