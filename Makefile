.PHONY: up down install migrate rebuild test integration

up:
	docker-compose up -d

down:
	docker-compose down

install:
	docker-compose exec app composer install

migrate:
	docker-compose exec app vendor/bin/doctrine orm:schema-tool:create

test:
	docker-compose exec app vendor/bin/phpunit tests/unit

integration:
	docker-compose exec app vendor/bin/phpunit tests/integration

bash:
	docker-compose exec app bash

rebuild:
	@echo "Stopping and removing old app container..."
	docker-compose stop app || true
	docker-compose rm -f app || true
	@echo "Rebuilding the app image..."
	docker-compose build --no-cache app
	@echo "Starting the app service..."
	docker-compose up -d app