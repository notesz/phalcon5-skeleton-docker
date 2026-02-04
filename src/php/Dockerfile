ARG PHP_VERSION=8.4.17
ARG PHALCON_VERSION=5.10.0

FROM php:${PHP_VERSION}-fpm

ARG PHALCON_VERSION

# Install system packages
RUN apt-get update && apt-get install -y --no-install-recommends \
    zip unzip git curl nodejs npm gettext imagemagick \
    && rm -rf /var/lib/apt/lists/*

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions


# Install PHP extensions (including Phalcon)
RUN install-php-extensions xdebug pdo_mysql zip intl pcntl gd exif gettext imagick redis mysqli phalcon-${PHALCON_VERSION}


WORKDIR "/"
COPY ../entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]
