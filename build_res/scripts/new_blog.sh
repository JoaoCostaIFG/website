#!/bin/sh

RES_DIR="build_res"
TEMPLATE_FILE="new.html"

f="$(mktemp)"
sed "s/date:/date: $(date --iso-8601)/" "${RES_DIR}/${TEMPLATE_FILE}" >"$f"

echo "Name? [blank for 'new']"
read -r title

# no title given
if [ -z "$title" ]; then
  mv "$f" "content/blog/${TEMPLATE_FILE}"
  exit
fi

sed -i "s/title:/title: ${title}/" "$f"
sed -i "s|<h2>title</h2>|<h2>${title}</h2>|" "$f"

file_name="$(printf "%s" "$title" | tr " " "_").html"
mv "$f" "content/blog/${file_name}"
