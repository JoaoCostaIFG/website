#!/bin/sh

cd /app/main || exit 1

php artisan storage:link

rm -rf /app/main/storage/app && ln -s /data/main/storage /app/main/storage/app

php artisan octane:status

php artisan octane:start -n --server=roadrunner --host=0.0.0.0 --port=8000
