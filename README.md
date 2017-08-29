Laravel Feature Flag
==============
Flagger component is a package that has been designed to help you enable feature flags in Laravel projects.

* [Version Compatibility](#version-compatibility)
* [Installation](#installation)
* [Configuration](#configuration)
* [Usage](#usage)
    * [flag](#flag)
    * [hasFeatureEnable](#hasfeatureenable)
    * [FlaggerMiddleware](#flaggermiddleware)

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

## Usage

### flag

First, make sure you create yours features in features table. You can use the Model ```Leet\Models\Feature``` for this.

After that use ```\Flagger::flag($flaggable, $feature)``` to attach one feature in to model:

```php
\Leet\Models\Feature::create([
    'name' => 'notifications',
    'description' => 'Notifications feature'
]);

$user = \App\User::first();

\Flagger::flag($user, 'notifications');
```

You can also add ```Leet\Models\FlaggerTrait``` in User Model:

```php
class User extends Model
{
    use \Leet\Models\FlaggerTrait;
}

$user = \App\User::first();

$user->flag('notifications');
```

### hasFeatureEnable

Anywhere in the application, you can check if a user has access to a feature:

```php
if (\Flagger::hasFeatureEnable($user, 'notifications')) {
    doSomething();
}

// or

if ($user->hasFeatureEnable('notifications')) {
    doSomething();
}
```

### FlaggerMiddleware

To use the FlaggerMiddleware, you need to declare it in the application kernel:

```php
protected $routeMiddleware = [
    // Other middleware...
    
    'flagger' => \Leet\Middleware\FlaggerMiddleware::class,
];
```

And on any authenticated route:

```php
Route::get('notifications', 'NotificationsController@index')->middleware('flagger:notifications');

// or

Route::group(['middleware' => 'flagger:notifications'], function () {});
```

### My Features

Make sure to add ```Leet\Models\FlaggerTrait``` in your User Model:

```php
// returns the features i have access to
$user->features;
```
