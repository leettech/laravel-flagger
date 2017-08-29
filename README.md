Laravel Feature Flag
==============
Flagger component is a package that has been designed to help you enable feature flags in Laravel projects.

* [Version Compatibility](#version-compatibility)
* [Installation](#installation)
* [Configuration](#configuration)
* [Usage](#usage)

## Version Compatibility

Laravel  | Flagger
:---------|:----------
 5.3.x    | 1.x.x
 
## Installation

To install through composer, simply put the following in your `composer.json` file:

```json
{
    "require": {
        "leettech/laravel-flagger": "~1.0"
    }
}
```

And then run `composer install` from the terminal.

### Quick Installation

Above installation can also be simplify by using the following command:

```sh
composer require "leettech/laravel-flagger=~1.0"
```

## Configuration

After installing the Flagger package, register the FlaggerServiceProvider in your config/app.php configuration file:

```php
'providers' => [
    // Other service providers...
    
    Leet\Providers\FlaggerServiceProvider::class,
],
```

Also, add the Flagger facade to the aliases array in your app configuration file:

```php
'aliases' => [
    // Other aliases...

    'Flagger' => Leet\Facades\Flagger::class,
],
```

Then run migration to create tables features and flaggables:

```sh
php artisan migrate
```

Publish the package configuration:

```sh
php artisan vendor:publish --provider="Leet\Providers\FlaggerServiceProvider"
```

And setup  what model it will be used in your config/flagger.php configuration file.
