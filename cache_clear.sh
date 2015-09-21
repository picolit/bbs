#!/bin/bash

php artisan cache:table
php artisan config:cache
php artisan route:cache