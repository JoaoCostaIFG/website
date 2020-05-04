#!/usr/bin/env sh

CONTENT_DIR="content"
RES_DIR="build_res"
RESULT_FILE="${CONTENT_DIR}/blog.html"

cp "${RES_DIR}/head.html" "${RESULT_FILE}"

printf "<h2>All of my blog posts</h2>\n\n" >>"${RESULT_FILE}"

printf "<ul>\\n" >>"${RESULT_FILE}"

# get the info from all pages
blogEntries="$(mktemp)"
for file in ${CONTENT_DIR}/blog/*.html; do
  # get page info field
  pageInfo="$(grep -A4 "^.*<!--PageInfo$" "$file")"

  postTitle="$(printf "%s" "$pageInfo" |
    grep "title" |
    sed 's/\s*title:\s*//g;s/"//g')"

  postDate="$(printf "%s" "$pageInfo" |
    grep "date" |
    sed 's/\s*date:\s*//g')"

  printf "<li><a href=\"/%s\">%s</a> - %s</li>\n" "$file" "$postTitle" "$postDate" >>"$blogEntries"
done

# sort page info by date
sort -t2 -r -k2 -k3 -k4 "$blogEntries" >> "${RESULT_FILE}"
rm "$blogEntries"

printf "</ul>\n" >>"${RESULT_FILE}"

cat "${RES_DIR}/foot.html" >>"${RESULT_FILE}"

