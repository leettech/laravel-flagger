<?php

namespace Leet\Providers;

use Illuminate\Support\ServiceProvider;
use Leet\Commands\FlaggerCommand;

class FlaggerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(dirname(__DIR__).'/database/migrations');

        $this->publishes([
            dirname(__DIR__).'/config/flagger.php' => config_path('flagger.php'),
        ]);
    }

    public function register()
    {
        $this->commands([
            FlaggerCommand::class,
        ]);
    }
}
