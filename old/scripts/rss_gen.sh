#!/bin/sh

CONTENT_DIR="content"
RESULT_FILE="atom.xml"

printf '<?xml version="1.0" encoding="UTF-8"?>
<feed xmlns="http://www.w3.org/2005/Atom" xml:lang="en">
  <title type="text">joaocosta.dev blog</title>
  <updated>%s</updated>
  <link rel="alternate" type="text/html" href="https://joaocosta.dev"/>
  <id>https://joaocosta.dev/atom.xml</id>
  <link rel="self" type="application/atom+xml" href="https://joaocosta.dev/atom.xml"/>\n' "$(date --iso-8601)" >"$RESULT_FILE"

blogEntries="$(mktemp)"
for file in ${CONTENT_DIR}/blog/*.html; do
  # get page info field
  pageInfo="$(grep -m 1 -A4 "^.*<!--PageInfo$" "$file")"

  postTitle="$(printf "%s" "$pageInfo" |
    grep "title" |
    sed 's/\s*title:\s*//g;s/"//g')"

  postDate="$(printf "%s" "$pageInfo" |
    grep "date" |
    sed 's/\s*date:\s*//g')"

  postDescription="$(printf "%s" "$pageInfo" |
    grep "description" |
    sed 's/\s*description:\s*//g')"

  printf "%s\t%s\t%s\t%s\n" "$postDate" "$postTitle" "$postDescription" "$file" >>"$blogEntries"
done

# sort page info by date
sort -t2 -r -k2 -k3 -k4 "$blogEntries" | head -n 5 |
  while IFS= read -r entry; do
    postDate="$(echo "$entry" | cut -d'	' -f1)"
    postTitle="$(echo "$entry" | cut -d'	' -f2)"
    postDescription="$(echo "$entry" | cut -d'	' -f3)"
    file="$(echo "$entry" | cut -d'	' -f4)"

    printf '  <entry>
    <title>%s</title>
    <link rel="alternate" type="text/html" href="https://joaocosta.dev/%s"/>
    <id>https://joaocosta.dev/%s</id>
    <updated>%s</updated>
    <published>%s</published>
    <content type="html"><![CDATA[%s]]></content>
  </entry>' "$postTitle" "$file" "$file" "$postDate" "$postDate" "$postDescription" >>"$RESULT_FILE"
  done

rm "$blogEntries"

printf '\n</feed>' >>"$RESULT_FILE"
