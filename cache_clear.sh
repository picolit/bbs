#!/bin/bash

php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan route:scan
php artisan route:cache
php artisan cache:clear
