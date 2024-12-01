#!/bin/sh

docker compose -f production.yml -f paperless.yml -f snikket.yml "$@"
