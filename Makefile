PROJECT_ALIAS := stf

build: infrastructure up composer migrations

infrastructure:
	mkdir -p ./.data
	mkdir -p ./.logs

up:
	docker-compose up -d --build --force-recreate

composer:
	docker exec -it $(PROJECT_ALIAS)_php /bin/sh -c "composer install"

migrations:
	docker exec -it $(PROJECT_ALIAS)_php /bin/sh -c "bin/console doctrine:migrations:migrate --no-interaction"

test:
	docker exec -it $(PROJECT_ALIAS)_php bin/phpcs --standard=phpcs.xml -s -p -w

cleanup:
	@sudo rm -rf ./.data > /dev/null 2>&1 || true
	@sudo rm -rf ./.logs > /dev/null 2>&1 || true
