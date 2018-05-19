#!/usr/bin/env bash
cd ./../
# Refresh database.
php artisan doctrine:migrations:refresh
# Seed database.
php artisan db:seed --class=TestsSeeder
# Run tests.
php vendor/phpunit/phpunit/phpunit --configuration phpunit.xml