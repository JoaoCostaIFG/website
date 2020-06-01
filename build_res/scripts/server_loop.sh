#!/bin/sh

# ok this script is incredibly stupid but I don't know better solutions yet

cd "build/"

while true; do
  cd ..
  make build
  sleep 1
done
