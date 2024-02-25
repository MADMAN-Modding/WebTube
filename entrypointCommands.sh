#!/bin/bash
mkdir /var/www/localhost/htdocs/videos
git pull
chmod 777 -R /var/www/localhost/htdocs/*
httpd -D FOREGROUND