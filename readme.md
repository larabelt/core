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
php artisan belt-core:publish
composer dumpautoload

# migrate & seed
php artisan migrate
php artisan db:seed --class=BeltCoreSeeder

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
```

## Acknowledgments / Credits

* [AdminLTE] (https://github.com/almasaeed2010/AdminLTE)