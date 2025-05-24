#!/bin/sh

docker compose -f production.yml -f immich.yml -f paperless.yml "$@"
