#!/bin/sh

php artisan storage:link

rm -rf /app/storage/app
ln -s /data/storage /app/storage/app

php artisan octane:frankenphp
