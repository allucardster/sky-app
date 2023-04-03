help: ## show this help
	@echo 'usage: make [target] ...'
	@echo ''
	@echo 'targets:'
	@egrep '^(.+)\:\ .*##\ (.+)' ${MAKEFILE_LIST} | sed 's/:.*##/#/' | column -t -c 2 -s '#'
composer-install: ## execute composer install
	docker exec -it sky-php sh -c "composer install --no-interaction"
database-drop: ## drop database through doctrine
	docker exec -it sky-php sh -c "./app/console doctrine:database:drop --if-exists --force"
database-create: ## create database through doctrine
	docker exec -it sky-php sh -c "./app/console doctrine:database:create --if-not-exists"
database-create-schema: ## create database schema through doctrine
	docker exec -it sky-php sh -c "./app/console doctrine:schema:create"
database-load-fixtures: ## load database fixtures
	docker exec -it sky-php sh -c "./app/console doctrine:fixtures:load --append --no-interaction"
fix-file-permissions: ## Setup and fixing file permissions for directories that require writable both by the web server and the command line user
	docker exec -it sky-php sh -c "chmod +x scripts/fix_perms.sh && scripts/fix_perms.sh"
database-init: database-drop database-create database-create-schema database-load-fixtures ## Initialize database
init-app: fix-file-permissions database-init ## Initialize the app

