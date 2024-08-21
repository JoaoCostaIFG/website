#!/bin/sh

docker compose -f production.yml -f matrix.yml -f paperless.yml "$@"
