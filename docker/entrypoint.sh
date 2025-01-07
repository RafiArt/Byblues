#!/bin/sh

# Jalankan migrasi dan mulai server Laravel
php artisan migrate
php artisan serve --host=127.0.0.1 --port=8000
