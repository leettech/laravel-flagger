<?php

namespace Leet;

use Illuminate\Support\ServiceProvider;

class FlaggerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    public function register()
    {
        //
    }
}
