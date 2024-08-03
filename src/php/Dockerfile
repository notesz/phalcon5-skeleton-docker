FROM php:8.2.10-fpm

# Update packages
RUN apt-get update
RUN apt-get install -y zip unzip git curl nodejs npm gettext exif imagemagick

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions

# Install PHP extensions
RUN install-php-extensions xdebug pdo_mysql zip intl pcntl gd exif gettext imagick

# Install psr
RUN cd /tmp \
    && curl -LO https://github.com/jbboehr/php-psr/archive/v1.2.0.tar.gz \
    && tar xzf /tmp/v1.2.0.tar.gz \
    && docker-php-ext-install -j $(getconf _NPROCESSORS_ONLN) /tmp/php-psr-1.2.0 \
    && rm -r /tmp/v1.2.0.tar.gz /tmp/php-psr-1.2.0

# Install phalcon
RUN cd /tmp \
    && curl -LO https://github.com/phalcon/cphalcon/archive/refs/tags/v5.3.1.tar.gz \
    && tar xzf /tmp/v5.3.1.tar.gz \
    && cd /tmp/cphalcon-5.3.1/build \
    && ./install \
    && docker-php-ext-enable phalcon \
    && rm -r /tmp/v5.3.1.tar.gz /tmp/cphalcon-5.3.1

COPY ../entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]
