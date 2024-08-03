#!/usr/bin/env bash
set -eo pipefail

cd /var/www/html
curl -sS https://getcomposer.org/installer | php
php composer.phar install

php ./vendor/bin/phalcon-migrations run

npm init -y
npm install webpack webpack-cli --save-dev
npm run build

exec "$@"
