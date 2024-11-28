#!/bin/sh

source "$ENV_PASSWORD_FILE"
php artisan env:decrypt --env=production
mv .env.production .env

php artisan optimize:clear
php artisan optimize
php artisan ziggy:generate

php artisan storage:link
rm -rf storage/app
ln -s /data/storage storage/app

php artisan octane:start
