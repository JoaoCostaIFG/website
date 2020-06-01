#!/bin/sh

# ok this script is incredibly stupid but I don't know better solutions yet

cd "build/" || {
  echo "There's no build directory. Exiting.."
  exit 0
}
python -m http.server 8080 &
server_pid="$!"
trap 'kill -9 ${server_pid}; exit 1' 2
sleep 1
cd ..

while true; do
  if [ "$(git status --porcelain)" ]; then
    echo "Server rebuilding.."
    make build
  fi

  sleep 1
done
