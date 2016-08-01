# OhioCMS User Package

wysiwyg
admin action buttons
slideouts
headings
pagination

## Migrations / Seeds / Factories

```sudo composer dumpautoload
```

```php artisan vendor:publish --provider="Ohio\Core\Base\OhioCoreServiceProvider" --force
```

```php artisan cache:clear; sudo service php5-fpm restart;
``` 

```php artisan migrate:refresh --seed #re-run all migrations with seeds
```