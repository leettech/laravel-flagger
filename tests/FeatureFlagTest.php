<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Leet\Flagger;
use Leet\Models\Feature;

class FeatureFlagTest extends TestCase
{
    use DatabaseMigrations;

    public function testUserCanSeeFeature()
    {
        $user = factory(config('flagger.model'))->create();

        $feature = factory(Feature::class)->create();

        Flagger::flag($user, $feature);

        $this->assertTrue(Flagger::canSee($user, $feature->name));
        $this->assertFalse(Flagger::canSee($user, factory(Feature::class)->create()->name));
    }
}
