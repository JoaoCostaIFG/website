#!/bin/sh

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

while true; do
  for entry in $(git status --porcelain | cut -c 4-); do
    hash="$(md5sum "${entry}")"

    # check if something should be rebuilt
    changed=0
    if ! grep "  ${entry}$" "$f" >/dev/null 2>&1; then # wasn't in the list
      changed=1
      echo "$hash" >>"$f"
    elif ! grep "$hash" "$f" >/dev/null 2>&1; then # was in list
      changed=1
      sed -i "s|.*${entry}$|${hash}|" "$f"
    fi

    # rebuild file in question
    if [ "$changed" -eq 1 ]; then
      echo "${entry} changed. Rebuilding.."
      "$BUILD_SCRIPT" "$entry"
    fi
  done

  sleep 1
done
