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
        return [\Leet\Providers\FlaggerServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Flagger' => \Leet\Facades\Flagger::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('flagger.model', \Tests\Stubs\User::class);
    }
}
