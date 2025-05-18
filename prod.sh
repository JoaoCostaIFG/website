#!/bin/sh

docker compose -f production.yml "$@"
docker compose -f immich.yml --env-file /usr/local/etc/immich.env "$@"
