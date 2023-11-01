#!/bin/sh

php artisan storage:link

rm -rf /app/storage/app
ln -s /data/storage /app/storage/app

rr serve -c ./.rr.yaml
