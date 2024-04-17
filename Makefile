sail = ./vendor/bin/sail
artisan = $(sail) artisan

install:
	$(sail) up -d
	$(artisan) migrate
	$(artisan) db:seed
	$(artisan) storage:link
	$(sail) npm i
	$(sail) npm run build


test:
	$(sail) test --filter ProfileTest

up:
	$(sail) up

analyse:
	./vendor/bin/phpstan analyse
