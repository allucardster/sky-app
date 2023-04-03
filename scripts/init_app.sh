#!/bin/bash

composer install --no-interaction
chmod +x scripts/fix_perms.sh && scripts/fix_perms.sh
./app/console doctrine:database:drop --if-exists --force
./app/console doctrine:database:create --if-not-exists
./app/console doctrine:schema:create
./app/console doctrine:fixtures:load --append --no-interaction
echo "> init_app.sh ----> done!"