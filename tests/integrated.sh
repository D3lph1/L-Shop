#!/usr/bin/env bash
cd ./../
# Refresh database.
php artisan doctrine:migrations:refresh
# Seeding database.
php artisan db:seed --class=TestsSeeder
# Run tests.
php vendor/phpunit/phpunit/phpunit --configuration phpunit.xml tests/Integrated