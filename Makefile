sail = ./vendor/bin/sail artisan

install:
	$(sail) migrate
	$(sail) db:seed
	$(sail) storage:link
	$(sail) npm build
	$(sail) up

test:
	$(sail) test

up:
	$(sail) up
