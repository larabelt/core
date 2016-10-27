# OhioCMS User Package

## Migrations / Seeds / Factories

```sudo composer dumpautoload
```

```php artisan vendor:publish --provider="Ohio\Core\Base\OhioCoreServiceProvider" --force
```

```composer run-script clear; sudo service php7.0-fpm restart;
``` 

```php artisan migrate:refresh --seed #re-run all migrations with seeds
```

## Testing

```phpunit -c vendor/ohiocms/core/src/base --coverage-html=vendor/ohiocms/core/src/base/tests/html
```