SkyApp
======

Requirements
============
- Docker (>= 20.x)
- Docker Compose (>= 2.x)
- Make

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
docker compose up -d #or docker compose up -d
```
- Initialize the application (install vendors and initialize database with random data)
```shell
make init-app
```
- In a web browser open the following url:
```shell
http://localhost:8081/app_dev.php/api/doc
```
- Enjoy!

Contributors
============
- Richard Melo [Github](https://github.com/allucardster), [Linkedin](https://www.linkedin.com/in/richardmelo)
