#!/bin/sh
set -e

sed "s|__MUSIC_URL__|${MUSIC_URL}|g" /var/www/html/shake.js.tmpl > /var/www/html/shake.js

exec apache2-foreground
