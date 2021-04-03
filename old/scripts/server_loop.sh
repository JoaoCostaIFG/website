#!/bin/sh

rebuild_file() {
  echo "'${1}' changed. Rebuilding.."
  "$BUILD_SCRIPT" "${1}"
}

BUILD_SCRIPT="build_res/scripts/build_pages.sh"
# not a typo. IFS is '\n'
IFS="
"

cd "build/" || {
  echo "There's no build directory. Exiting.."
  exit 0
}
python -m http.server 8080 &
server_pid="$!"
trap 'kill -9 ${server_pid}; rm -f ${f}; exit 1' 2
sleep 1
cd ..

# init 'changes' file
f="$(mktemp)"
for entry in $(git status --porcelain | cut -c 4-); do
  md5sum "${entry}" >>"$f"
done

prev_entries=""
while true; do
  new_entries=""
  for entry in $(git status --porcelain | cut -c 4-); do
    new_entries="${new_entries}
${entry}"

    hash="$(md5sum "${entry}")"

    # check if something should be rebuilt
    changed=0
    if ! grep -q "  ${entry}$" "$f"; then # wasn't in the list
      changed=1
      echo "$hash" >>"$f"
    elif ! grep -q "$hash" "$f"; then # was in list
      changed=1
      sed -i "s|.*${entry}$|${hash}|" "$f"
    fi

    # rebuild file in question
    [ "$changed" -eq 1 ] && rebuild_file "$entry"
  done

  # rebuild if entry was listed last time and isn't right now
  for entry in $prev_entries; do
    if ! echo "$new_entries" | grep -q "^${entry}$"; then
      rebuild_file "$entry"
    fi
  done

  prev_entries="$new_entries"

  sleep 1
done
