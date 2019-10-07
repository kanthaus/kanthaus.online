#!/bin/bash
# 1. Runs the grav development server
# 2. gets all available pages from the sitemap
# 3. opens each of them with curl
# If there's any page with status code != 200, this script fails

set -e

cleanup()
{
    echo
    echo "killing server with PID" "$SERVER_PID"
    kill -9 "$SERVER_PID"
}
trap cleanup EXIT

php -S localhost:8000 system/router.php 2> /dev/null &
SERVER_PID=$!

while [[ $(curl -s -o /dev/null -w "%{http_code}" localhost:8000/sitemap) != "200" ]]
do sleep 0.1
done

SITEMAP=$(curl -s http://localhost:8000/sitemap)

URLS=$(sed -n 's/^.*<loc>\(.*\)<\/loc>.*$/\1/p' <<< "${SITEMAP}")


echo
echo testing "$(wc -l <<< "$URLS")" URLs...

for URL in $URLS
do
  CODE=$(curl -s -o /dev/null -w "%{http_code}" "$URL")
  if [[ x"$CODE" == x"200" ]]; then
    printf "."
  else
    echo "this url is broken:" "$URL"
    exit 1
  fi
done

echo
echo Successfully finished.
