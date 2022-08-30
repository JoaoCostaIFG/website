#!/bin/sh

cd /app/main && php artisan storage:link

rm -rf /app/main/storage/app
ln -s /data/storage /app/main/storage/app

php-fpm -R
