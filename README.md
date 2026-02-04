# phalcon5-skeleton-docker
Docker for phalcon5-skeleton with PHP-FPM 8.2, Phalcon 5.3, MariaDB 10 and Redis 7 on Alpine Linux

Repository: https://github.com/notesz/phalcon5-skeleton-docker

## Goal of this project
The goal of this container is to provide an example for running PHP8 and Phalcon5 in a container which follows the best practices and is easy to understand and modify to your needs.

Originally it has been designed for [phalcon5-skeleton](https://github.com/notesz/phalcon5-skeleton). \
Before run docker-compose, copy the project into www folder and modify APP_ROOT in .env.

* Uses PHP 8.4 and Phalcon 5.10
* Uses main PHP extensions: bcmath, ctype, curl, exif, gd, imagick, json, mbstring, pdo, etc...
* Uses MariaDB 12 (with phpMyAdmin)
* Uses Redis 8
* Uses ElasticSearch 8
* Install and run composer
* Run Phalcon migration
* Install webpack and run a build

## Usage

### Preparation

1. Download the files
2. Create a .env from .env.example and modify it in the main folder (the example contains my recommended settings)
3. Modify your project config. The database host is `database`, redis host is `redis` and ElasticSearch is `elasticsearch`.

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

If you want to use [phalcon-skeleton](https://github.com/notesz/phalcon5-skeleton) you can find more info about it [here](https://github.com/notesz/phalcon5-skeleton).
