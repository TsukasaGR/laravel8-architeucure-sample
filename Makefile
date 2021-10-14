init:
	cp .env.example .env
	docker run --rm \
		-u "$(shell id -u):$(shell id -g)" \
		-v $(shell pwd):/opt \
		-w /opt \
		laravelsail/php80-composer:latest \
		composer install --ignore-platform-reqs
	@make init-laravel
	@make migrate
	@make seed
	@make yarn-install
	@make yarn-build
init-laravel:
	docker compose up -d
	docker compose exec laravel.test php artisan key:generate
	docker compose exec laravel.test php artisan storage:link
	docker compose exec laravel.test chmod -R 777 storage bootstrap/cache
migrate:
	docker compose exec laravel.test php artisan migrate
seed:
	docker compose exec laravel.test php artisan db:seed
yarn-install:
	docker compose exec laravel.test yarn
yarn-build:
	docker compose exec laravel.test yarn prod
