<?php

namespace Tests;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->loadLaravelMigrations(['--database' => 'testing']);

        $this->withFactories(__DIR__.'/factories');
    }

    protected function getPackageProviders($app)
    {
        return [\Leet\FlaggerServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Flagger' => \Leet\Flagger::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('flagger.model', \Illuminate\Foundation\Auth\User::class);
    }
}
