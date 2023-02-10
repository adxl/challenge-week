.PHONY:

bdd: 
	docker compose exec php bin/console d:d:d --if-exists --force 
	docker compose exec php bin/console d:d:c 
	docker compose exec php bin/console d:s:c
	docker compose exec php bin/console d:f:l -n

bdd_test: 
	docker compose exec php bin/console d:d:d --if-exists --force --env=test
	docker compose exec php bin/console d:d:c --env=test
	docker compose exec php bin/console d:s:c --env=test