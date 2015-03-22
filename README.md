## Authentication Adapter For Laravel 5 Using Doctrine Models

This package allows a Doctrine model based authentication for Laravel 5. Tries to avoid
multiple ways to access database for projects using [laravel-doctrine](https://github.com/atrauzzi/laravel-doctrine)
package.

### Installation

Configure [laravel-doctrine](https://github.com/atrauzzi/laravel-doctrine)
package with DriverChain driver.

Require `barnetik/doctrine-auth-provider` in composer.json and run `composer update`.

    {
        "require": {
            "laravel/framework": "5.0.*",
            ...
            "barnetik/doctrine-auth-provider": "*"
        }
        ...
    }

Composer will download the package. After the package is downloaded, open `config/app.php` and add the service provider:

    'providers' => array(
        ...
        'Barnetik\DoctrineAuth\DoctrineAuthServiceProvider',
    ),


Publish assets so migrations can be executed:

```php
$ php artisan vendor:publish
```

Execute migration to generate users table:

```php
$ php vendor/bin/doctrine-laravel migrations:migrate
```

If desired, generate user with provided command:

```php
$ php artisan doctrine-auth:user:create --username=admin --password=1234
```

### Usage

Open `config/auth.php` and set appropiate driver and model:

    [
        ...
        'driver' => 'doctrine',
        'model' => 'Barnetik\DoctrineAuth\User',
        ...
    ]

Use authentication as explained on Laravel's [Authentication](http://laravel.com/docs/5.0/authentication)
chapter.

### License

The Laravel framework is open-sourced software license under the [MIT license](http://goo.gl/tuwnQ)

This project is too to ensure maximum compatibility.