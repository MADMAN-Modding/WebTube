#!/bin/bash
mkdir /var/www/localhost/htdocs/videos
git reset --hard HEAD && git clean -f -d && git pull && chmod 777 -R /var/www/localhost/htdocs/* && httpd -D FOREGROUND