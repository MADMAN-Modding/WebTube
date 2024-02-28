#!/bin/bash
mkdir /var/www/localhost/htdocs/videos
chmod 777 -R /var/www/localhost/htdocs/*
httpd -D FOREGROUND