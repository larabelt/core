## Installation

Add the ServiceProvider to the providers array in config/app.php

```php
Belt\Core\BeltCoreServiceProvider::class,
```

```
# publish
php artisan belt-core:publish
composer dumpautoload

# migration
php artisan migrate

# seed
php artisan db:seed --class=BeltCoreSeeder

# compile assets
npm run
```
