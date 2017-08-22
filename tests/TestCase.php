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
}
