.PHONY:

bdd: 
	docker compose exec php bin/console d:d:d --force 
	docker compose exec php bin/console d:d:c 
	docker compose exec php bin/console d:s:c
	docker compose exec php bin/console d:f:l -n