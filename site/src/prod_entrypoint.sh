#!/bin/sh

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan ziggy:generate

php artisan storage:link
rm -rf storage/app
ln -s /data/storage storage/app

source "$ENV_PASSWORD_FILE"
php artisan env:decrypt --env=production

php artisan octane:start
