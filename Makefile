sail = ./vendor/bin/sail
artisan = $(sail) artisan

install:
	$(artisan) migrate
	$(artisan) db:seed
	$(artisan) storage:link
	$(sail) npm run build
	$(artisan) up

test:
	$(sail) test --filter ProfileTest

up:
	$(sail) up
