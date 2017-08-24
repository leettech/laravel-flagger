<?php

namespace Tests;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Leet\Flagger;
use Leet\FlaggerService;
use Leet\Models\Feature;
use Mockery;

class FlaggerServiceTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();

        $this->builder = Mockery::mock(Builder::class);

        $this->user = Mockery::mock(User::class);

        $this->feature = Mockery::mock(Feature::class);

        $this->feature
            ->shouldReceive('where')
            ->andReturn($this->builder);
    }

    /**
     * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testFlagWithFeatureNotFound()
    {
        $this->builder
            ->shouldReceive('firstOrFail')
            ->andThrow(ModelNotFoundException::class);

        $flagger = new FlaggerService($this->feature);

        $flagger->flag($this->user, 'notifications');
    }

    public function testFlag()
    {
        $user = factory(config('flagger.model'))->create();

        $feature = factory(Feature::class)->create();

        try {
            Flagger::flag($user, $feature->name);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testHasFeatureEnable()
    {
        $user = factory(config('flagger.model'))->create();

        $feature = factory(Feature::class)->create();

        Flagger::flag($user, $feature->name);

        $this->assertTrue(Flagger::hasFeatureEnable($user, $feature->name));
        $this->assertFalse(Flagger::hasFeatureEnable($user, factory(Feature::class)->create()->name));
    }
}
