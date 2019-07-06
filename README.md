# Voyager CMS

This package provides custom CMS functionality to the [laravel voyager](https://laravelvoyager.com) admin panel.

*Note:* This package does not use the hooks extension management from voyager.

# Installation

You can install this package using composer.

```bash
composer require tjventurini/voyager-cms 
```

This package needs to have the `voyager.prefix` settings available in the voyager configuration file. Put the following to the top of your voyager configuration file configuration.

```php
return [

    /*
    |--------------------------------------------------------------------------
    | Voyager Prefix
    |--------------------------------------------------------------------------
    |
    | The global voyager prefix (eg. `admin`). Make sure that it is the same
    | slug, as in voyager.user.redirect setting below.
    |
    */
    
    'prefix' => 'admin',

    ...
```

Voyager CMS commes with a handy install command, that will run all the installation commands for you.

```bash
php artisan voyager-cms:install
```

*Note:* Use the `--force` flag to refresh the whole setup. This will refresh the migrations, run the seeders, overwrite the configurations, translations and views.