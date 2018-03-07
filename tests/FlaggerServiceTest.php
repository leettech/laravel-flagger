<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Flagger;
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

        Flagger::flag($user, $feature->name);

        $this->assertDatabaseHas('flaggables', [
            'feature_id' => $feature->id,
            'flaggable_id' => $user->id,
            'flaggable_type' => config('flagger.model'),
        ]);
    }

    public function testHasFeatureEnabled()
    {
        $user = factory(config('flagger.model'))->create();

        $feature = factory(Feature::class)->create();

        Flagger::flag($user, $feature->name);

        $this->assertTrue(Flagger::hasFeatureEnabled($user, $feature->name));
        $this->assertFalse(Flagger::hasFeatureEnabled($user, factory(Feature::class)->create()->name));
    }
}
