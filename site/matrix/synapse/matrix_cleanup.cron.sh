#!/bin/sh

docker exec -it -e UPDATE_DURATION="7d" synapse /cleanup.sh
