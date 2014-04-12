#!/bin/bash

rm -rf app/cache/* app/logs/*
chmod -R 777 app/cache app/logs web
php app/console assetic:dump
chmod -R 777 app/cache app/logs web
php app/console assets:install
php app/console assets:install --symlink
chmod -R 777 app/cache app/logs web