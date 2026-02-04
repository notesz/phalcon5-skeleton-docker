# phalcon5-skeleton-docker

Docker for phalcon5-skeleton with PHP-FPM 8.2, Phalcon 5.3, MariaDB 10 and Redis 7 on Alpine Linux.

Repository: https://github.com/notesz/phalcon5-skeleton-docker

Originally it has been designed for [phalcon5-skeleton](https://github.com/notesz/phalcon5-skeleton).

## Stack

| Service           | Technology                                             |
|-------------------|--------------------------------------------------------|
| **php**           | PHP-FPM + Phalcon (versions configurable via `.env`)   |
| **nginx**         | Nginx 1.28                                             |
| **database**      | MariaDB 12.1.2                                         |
| **redis**         | Redis 8.4                                              |
| **elasticsearch** | Elasticsearch 8.17                                     |
| **phpmyadmin**    | phpMyAdmin                                             |


## Installation

### Configuration

Create a .env from .env.example and configure it:

```env
APP_NAME=php8phalcon5

APP_ROOT=/Users/notesz/Developer/projectname
PHP_VERSION=8.4.17
PHALCON_VERSION=5.10.0

APP_PORT=80
PMA_PORT=8080
DB_PORT=3306

MYSQL_DATABASE=php8phalcon5
MYSQL_ROOT_USER=root
MYSQL_ROOT_PASSWORD=<password>
MYSQL_USER=php8phalcon5
MYSQL_PASSWORD=<password>

REDIS_PORT=6379

ES_VERSION=8.17.2
ES_PORT=9200
ES_PASSWORD=<password>
```

### Starting the containers

```bash
docker-compose up -d --build
```

### Opening the application

The application is available at `http://localhost` (or the port specified in `APP_PORT`).

## Usage

```bash
# Start services
docker-compose up -d

# Stop services
docker-compose down

# Rebuild (after Dockerfile changes)
docker-compose up -d --build

# View logs
docker-compose logs -f [service]    # service: php, nginx, database, redis, elasticsearch, phpmyadmin

# Run a command in the PHP container
docker-compose exec php bash

# Composer install
docker-compose exec php composer install

# Run Phalcon migrations
docker-compose exec php vendor/bin/phalcon-migrations run
```

## Architecture

Six Docker services on a shared bridge network (named after `APP_NAME`):

```
                    :80                    :8080
                     |                       |
                  [nginx]              [phpmyadmin]
                     |                       |
                     | FastCGI :9000         |
                     v                       v
                   [php] ──────────────> [database] :3306
                     |
                     ├──> [redis] :6379
                     |
                     └──> [elasticsearch] :9200
```

- **nginx** -- Reverse proxy, forwards PHP requests to the `php` container via FastCGI. Phalcon routing URL rewriting configured.
- **php** -- PHP-FPM with Phalcon extension. Includes: xdebug, pdo_mysql, redis, imagick, gd, intl, Node.js/npm.
- **database** -- MariaDB. Data persisted to `./data/mysql`. Port bound to localhost only.
- **redis** -- Data persisted to `./data/redis`. Port bound to localhost only.
- **elasticsearch** -- Elasticsearch single-node. Data persisted to `./data/elasticsearch`. Port bound to localhost only. User: `elastic`, password from `.env`.
- **phpmyadmin** -- Web-based database management interface.

## Directory Structure

```
.
├── config/
│   ├── nginx/conf.d/default.conf   # Nginx server configuration
│   ├── php/
│   │   ├── timezone.ini            # Timezone (Europe/Budapest)
│   │   └── file.ini                # Upload limit (1024M)
│   ├── elasticsearch/
│   │   └── elasticsearch.yml       # Elasticsearch configuration
│   └── crontabs/root               # Cron schedule
├── data/
│   ├── mysql/                      # MariaDB persistent data
│   ├── redis/                      # Redis persistent data
│   ├── elasticsearch/              # Elasticsearch persistent data
│   └── nginx/                      # Nginx logs
├── src/
│   ├── php/Dockerfile              # PHP-FPM image
│   ├── nginx/Dockerfile            # Nginx image
│   └── entrypoint.sh               # PHP container init script
├── www/                            # phalcon5-skeleton app
├── docker-compose.yml
└── .env                            # Environment variables
```

## Configuration

### Switching projects

The `APP_ROOT` variable in `.env` defines the absolute path to the application source code. To switch to another project, update the value and restart the containers:

```bash
# In .env: APP_ROOT=/new/project/path/www
docker-compose up -d
```
