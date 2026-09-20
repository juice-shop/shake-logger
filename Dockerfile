FROM docker.io/php:7.2-apache

# Original: https://github.com/Elfoslav/harlem-shake/raw/master/music/harlem-shake.ogg (subject to copyright, "Harlem Shake" by Baauer)
ENV MUSIC_URL=https://upload.wikimedia.org/wikipedia/commons/f/f1/Dubstep_drop_example.ogg

COPY shake.css logger.php /var/www/html/
COPY shake.js /var/www/html/shake.js.tmpl
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]
