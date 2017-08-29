<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Leet\Flagger;
use Leet\Models\Feature;

class HasFeatureTraitTest extends TestCase
{
    use DatabaseMigrations;

    public function testHasFeatureEnable()
    {
        $user = factory(config('flagger.model'))->create();

        $feature = factory(Feature::class)->create();

        Flagger::flag($user, $feature->name);

        $this->assertTrue($user->hasFeatureEnable($feature->name));
        $this->assertFalse($user->hasFeatureEnable(factory(Feature::class)->create()->name));
    }
}
