SkyApp
======

Requirements
============
- Docker (>= 20.x)
- Docker Compose (>= 2.x)
- Make (optional)

Technology Stack
================
- Composer 2.2.9
- PHP 7.2
- Symfony 2.8
- MySQL 8.0
- Nginx 1.22.x

Setup
=====
- Init docker containers
```shell
docker compose up -d #or docker-compose up -d
```
- Install vendors
```shell
## Using make
make composer-install
## In case you don't have make installed
docker exec -it sky-php sh -c "composer install --no-interaction"
```
- Initialize the application (fix directory permisions and initialize database with random data)
```shell
## Using make
make init-app
## In case you don't have make installed
docker exec -it sky-php sh -c "chmod +x scripts/init_app.sh && scripts/init_app.sh"
```
- In a web browser open the following url:
```shell
http://localhost:8081/app_dev.php/api/doc
```
- Enjoy!

Contributors
============
- Richard Melo [Github](https://github.com/allucardster), [Linkedin](https://www.linkedin.com/in/richardmelo)
