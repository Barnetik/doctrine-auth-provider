## Authentication Adapter For Laravel 5 Using Doctrine Models

This package allows a Doctrine model based authentication for Laravel 5. Tries to avoid
multiple ways to access database for projects using [laravel-doctrine](https://github.com/atrauzzi/laravel-doctrine)
package.

### Installation

Configure [laravel-doctrine](https://github.com/atrauzzi/la
ravel-doctrine)
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


### Usage

#### User model definition
 
Copy the base model to your models path using this command:

```shell
$ php artisan doctrine-auth:publish:usermodel \My\Models\Path
```

Take care about the **PATH**, the command will use de app_path() as base path.

#### Table creation

Once the Model is in its place, create the table in the DB.

Generate a migration diff :

```shell
$ php vendor/bin/doctrine-laravel migrations:diff
```

Check the generated file and if everything is ok, do the migration:

```shell
$ php vendor/bin/doctrine-laravel migrations:migrate
```


#### Configuration

Open `config/auth.php` and set appropiate driver and model:

    [
        ...
        'driver' => 'doctrine',
        'model' => 'My\Models\Path\User',
        ...
    ]

Use authentication as explained on Laravel's [Authentication](http://laravel.com/docs/5.0/authentication)
chapter.

If desired, generate user with provided command:

```php
$ php artisan doctrine-auth:user:create --username=admin --password=1234
```

### License

The Laravel framework is open-sourced software license under the [MIT license](http://goo.gl/tuwnQ)

This project is too to ensure maximum compatibility.