#!/bin/bash

chmod -R 777 ./bootstrap/cache/

composer dump-autoload
composer install --no-scripts
composer update

php artisan migrate:fresh --seed
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan serve --port=$PORT --host=0.0.0.0

exec docker-php-entrypoint "$@"
