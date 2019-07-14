# Voyager CMS

This package provides custom CMS functionality to the [laravel voyager](https://laravelvoyager.com) admin panel.

*Note:* This package does not use the hooks extension management from voyager.

# Installation

You can install this package using composer. First update your `composer.json`.

```json
    "repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:tjventurini/voyager-cms.git"
        },
        {
            "type": "vcs",
            "url": "git@github.com:tjventurini/voyager-tags.git"
        },
        {
            "type": "vcs",
            "url": "git@github.com:tjventurini/voyager-projects.git"
        },
        {
            "type": "vcs",
            "url": "git@github.com:tjventurini/voyager-pages.git"
        },
        {
            "type": "vcs",
            "url": "git@github.com:tjventurini/voyager-posts.git"
        },
        {
            "type": "vcs",
            "url": "git@github.com:tjventurini/voyager-content-blocks.git"
        }
    ],
```

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

# GraphQL

For the headless part to work you will need a little bit of extra work.

## Enable the Middleware

To enable the middleware you need have to update your `app/Http/Kernel.php`.

```php
    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        // ...
        'projectToken' => \Tjventurini\VoyagerProjects\Http\Middleware\VerifyProjectToken::class,
    ];
```

# Authentication with Passport

If you want to use the authentication provided for graphql via [laravel passport](https://laravel.com/docs/5.8/passport), then you will have to update the user model. Add the `HasApiTokens` trait to your user model.

```php
<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends \TCG\Voyager\Models\User
{
    use HasApiTokens, Notifiable;
```

Next you need to add the passport routes to the `AuthServiceProvider`.


```php
<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
    }
}
```

Finally update your `config/auth.php`.

```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],

    'api' => [
        'driver' => 'passport',
        'provider' => 'users',
    ],
],
```