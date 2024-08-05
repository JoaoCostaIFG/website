#!/bin/sh

set -eu

DEFAULT_HOSTNAME="http://localhost:5984"
printf "Hostname? [%s] " "$DEFAULT_HOSTNAME"
read -r v
[ "$v" ] && hn="$v" || hn="$DEFAULT_HOSTNAME"

DEFAULT_DATABASE="obsidiannotes"
printf "Database name? [%s] " "$DEFAULT_DATABASE"
read -r v
[ "$v" ] && db="$v" || db="$DEFAULT_DATABASE"

DEFAULT_PASSWORD="notespass"
printf "Database password? [%s] " "$DEFAULT_PASSWORD"
read -r v
[ "$v" ] && pw="$v" || pw="$DEFAULT_PASSWORD"

printf "Uri passphrase (if empty one will be auto generated) [] "
read -r v
[ "$v" ] && up="$v" || up=""

export OBSIDIAN_HOSTNAME="$hn"
export OBSIDIAN_DATABASE="$db"
export OBSIDIAN_PASSPHRASE="$pw"

if [ "$up" ]; then
  # if unset, will generate a random one
  export OBSIDIAN_URI_PASSPHRASE="$up"
fi

deno run -A /generate_setupuri.ts

