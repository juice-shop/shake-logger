#!/bin/sh

sed -i "s/localhost:80/$TARGET_SOCKET/" /var/www/html/shake.js && apache2-foreground
