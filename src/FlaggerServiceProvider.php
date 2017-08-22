<?php

namespace Leet;

use Illuminate\Support\ServiceProvider;

class FlaggerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        $this->publishes([
            __DIR__.'/config/flagger.php' => config_path('flagger.php'),
        ]);
    }

    public function register()
    {
        //
    }
}
