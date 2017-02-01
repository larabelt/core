## Installation

```
# install composer dependencies
composer install

# install node dependencies
npm install

# create .env file
cp .env.example .env

# create app key
php artisan key:generate

# install assets & migrate
php artisan ohio-core:publish
composer dumpautoload

# migrate & seed
php artisan migrate
php artisan db:seed --class=OhioCoreSeeder

# compile assets
gulp
```

## Clear App & PHP cache

```
composer run-script clear;
sudo service php7.0-fpm restart;
```

## Misc

```
#re-run all migrations with seeds
php artisan migrate:refresh --seed 

# unit testing
phpunit --bootstrap=bootstrap/app.php --coverage-html=public/tests/ohio/core -c ../core/tests
phpunit --coverage-html=public/tests/ohio/core/base      -c vendor/ohiocms/core/tests/base      --bootstrap=bootstrap/autoload.php
phpunit --coverage-html=public/tests/ohio/core/role      -c vendor/ohiocms/core/tests/role      --bootstrap=bootstrap/autoload.php
phpunit --coverage-html=public/tests/ohio/core/team      -c vendor/ohiocms/core/tests/team      --bootstrap=bootstrap/autoload.php
phpunit --coverage-html=public/tests/ohio/core/user      -c vendor/ohiocms/core/tests/user      --bootstrap=bootstrap/autoload.php
```

## Acknowledgments / Credits

* [AdminLTE] (https://github.com/almasaeed2010/AdminLTE)