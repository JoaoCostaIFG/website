#!/bin/sh

cd /app/main &&
  npx tailwindcss -i ./resources/css/style_input.css -o ./resources/css/style.css --watch &
nginx -g 'daemon off;'
