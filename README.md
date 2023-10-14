# phalcon5-skeleton-docker
Docker for phalcon5-skeleton with PHP-FPM 8.2, Phalcon 5.3, MariaDB 10 and Redis 7 on Alpine Linux

Repository: https://github.com/notesz/phalcon5-skeleton-docker

## Goal of this project
The goal of this container is to provide an example for running PHP8 and Phalcon5 in a container which follows the best practices and is easy to understand and modify to your needs.

Originally it has been designed for [phalcon5-skeleton](https://github.com/notesz/phalcon5-skeleton). \
So the project folder contains the release [1.1](https://github.com/notesz/phalcon5-skeleton/releases/tag/1.1).

The Dockerfile based on [zhuzhu/php:8.2-fpm-phalcon-5.3.1](https://hub.docker.com/layers/zhuzhu/php/8.2-fpm-phalcon-5.3.1/images/sha256-1c2b2a84a891fb6ae32c53723fc2de63219683e069756036f6d0dea0d0383937?context=explore). You can modify it in the Dockerfile if you need.

* Uses PHP 8.2 and Phalcon 5.3
* Uses main PHP extensions: bcmath, ctype, curl, exif, gd, imagick, json, mbstring, pdo, etc...
* Uses MariaDB 10 (with phpMyAdmin)
* Uses Redis 7
* Install and run composer
* Run Phalcon migration
* Install webpack and run a build

## Usage

### Preparation

1. Download the files
2. Create a .env from .env.example and modify it in the main folder (the example contains my recommended settings)
3. Modify your project config. If your `APP_NAME` is `php8phalcon5`, the database host is `php8phalcon5_mariadb`, redis host is `php8phalcon5_redis`.

### Run container

In the main directory run the container with docker-compose

```shell
docker-compose up -d
```

When your environment was launched you can open it in your browser.

1. your project: http://localhost
2. phpMyAdmin: http://localhost:8080

You can edit these port numbers in your .env: `APP_PORT`, `PMA_PORT`

### Stop container

In the main directory stop tha container with docker-compose

```shell
docker-compose down
```

### Important notes

This container contains [phalcon-skeleton](https://github.com/notesz/phalcon5-skeleton) project in `/www` folder.

If you want to run your own project delete it. And if you don't use composer, phalcon migration or webpack don't forget to remove these commands from `./src/entrypoint.sh` before run dokcer-compose.

If you want to use [phalcon-skeleton](https://github.com/notesz/phalcon5-skeleton) you can find more info about it [here](https://github.com/notesz/phalcon5-skeleton).
