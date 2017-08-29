Laravel Flagger
==============
Flagger is a package that has been designed to help you on enabling feature flags in Laravel projects.

* [Version Compatibility](#version-compatibility)
* [Installation](#installation)
* [Configuration](#configuration)
* [Usage](#usage)
    * [flag](#flag)
    * [hasFeatureEnabled](#hasfeatureenabled)
    * [FlaggerMiddleware](#flaggermiddleware)
    * [Getting enabled features for a model](#getting-enabled-features-for-a-model)

## Version Compatibility

Laravel   | Flagger
:---------|:----------
 5.3.x    | 1.x.x

## Installation

To install through composer, simply add the following in your `composer.json` file:

```json
{
    "require": {
        "leettech/laravel-flagger": "~1.0"
    }
}
```

And then run `composer install`.

### Quick Installation

The above installation can also be simplified by using the following command:

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

Then run the migration script to create `features` and `flaggables` tables:

```sh
php artisan migrate
```

Publish the package configuration:

```sh
php artisan vendor:publish --provider="Leet\Providers\FlaggerServiceProvider"
```

And, in your `config/flagger.php` configuration file, specify which model will have feature flags associated to it (by default it's set to `App\User::class`).

## Usage

First of all, make sure you have inserted your features in the `features` table in the database. You can use the model `Leet\Models\Feature` for this:

```php
\Leet\Models\Feature::create([
    'name' => 'notifications',
    'description' => 'Notifications feature'
]);
```

### flag
Use `\Flagger::flag($flaggable, $feature)` to attach a feature to a model:

```php
$user = \App\User::first();
\Flagger::flag($user, 'notifications');
```

You can also add `Leet\Models\FlaggerTrait` to the model in order to make flagger methods available from it:

```php
class User extends Model
{
    use \Leet\Models\FlaggerTrait;
}
$user = \App\User::first();
$user->flag('notifications');
```

### hasFeatureEnabled

Anywhere in the application, you can check if a user has access to a feature:

```php
if ($user->hasFeatureEnabled('notifications')) {
    doSomething();
}
```

### FlaggerMiddleware

To use the FlaggerMiddleware, you have to declare it in the application kernel:

```php
protected $routeMiddleware = [
    // Other middleware...
    'flagger' => \Leet\Middleware\FlaggerMiddleware::class,
];
```

And on any authenticated route:

```php
Route::get('notifications', 'NotificationsController@index')->middleware('flagger:notifications');
```
or
```php
Route::group(['middleware' => 'flagger:notifications'], function () {
    Route::get('notifications', 'NotificationsController@index');
    Route::post('notifications', 'NotificationsController@store')
});
```

### Getting enabled features for a model

By adding ```Leet\Models\FlaggerTrait``` to your model, you are able to access its enabled features:

```php
// returns the features a user have access to
$user->features;
```
