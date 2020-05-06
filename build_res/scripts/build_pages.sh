#!/usr/bin/env sh

FILENAMES="files"
OUT_DIR="build"

rm -rf "$OUT_DIR"
mkdir -p "$OUT_DIR"

RES_DIR="build_res"
head="$(cat "${RES_DIR}/head.html")"
foot="$(cat "${RES_DIR}/foot.html")"

print_usage() {
  printf "%s [html file to build] || [file with list of files to build]\n" "$0"
  printf "Otherwise, fallback to all html files with PageInfo on dir.\n"
  exit 1
}

build_file() {
  [ $# -ne 1 ] && {
    echo "build_file requires a single argument."
    exit 1
  }

  out_file="${OUT_DIR}/$1"
  mkdir -p "$(dirname "$out_file")"

  printf "%s\n\n" "$head" >"$out_file"
  cat "$1" >>"$out_file"
  printf "\n%s" "$foot" >>"$out_file"
}

build_all() {
  [ $# -ne 1 ] && {
    echo "build_all requires a single argument."
    exit 1
  }

  while read -r file_name; do
    build_file "$file_name"
  done <"$1"
}

has_page_info() {
  [ $# -eq 0 ] && return 1
  if grep -m 1 -A4 "^.*<!--PageInfo$" "$1" >/dev/null 2>&1; then
    return 0
  else
    return 1
  fi
}

list_all_html() {
  [ $# -ne 1 ] && {
    echo "list_all_html requires a single argument."
    exit 1
  }

  printf "" >"$1" # clear list output file

  for file in $(find . -type f -not -path "./.git/*" | sed "s|^\./||"); do
    if has_page_info "$file"; then
      printf "%s\n" "$file" >>"$1"
    fi
  done
}

if [ $# -eq 0 ]; then
  list_all_html "$FILENAMES"
  build_all "$FILENAMES"
elif [ -f "$1" ]; then
  if has_page_info "$1"; then
    build_file "$1"
  else
    build_all "$1"
  fi
else
  print_usage
fi
