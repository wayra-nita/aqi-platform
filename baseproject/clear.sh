#!/bin/sh

chmod -R 777 app/cache app/logs web
rm -rf app/cache/* app/logs/*
chmod -R 777 app/cache app/logs web