#!/bin/sh

source "$ENV_PASSWORD_FILE"
php artisan env:decrypt --env=production

php artisan octane:start
