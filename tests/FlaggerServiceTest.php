<?php

namespace Tests;

use Exception;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Leet\Flagger;
use Leet\Models\Feature;

class FlaggerServiceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testFlagWithFeatureNotFound()
    {
        $user = factory(config('flagger.model'))->create();

        Flagger::flag($user, 'notifications');
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
