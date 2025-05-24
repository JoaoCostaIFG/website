#!/bin/sh

docker compose -f production.yml -f immich.yml --env-file /usr/local/etc/immich.env "$@"
