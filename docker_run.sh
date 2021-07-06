#!/bin/bash

set -e

cd /usr/share/nginx/joaocosta.dev/main
composer install
make clean_cache

php-fpm7 -D
nginx -g "daemon off;"

