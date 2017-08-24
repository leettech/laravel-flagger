<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Leet\Flagger;
use Leet\Models\Feature;

class FlaggerServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function testUserhasFeatureEnable()
    {
        $user = factory(config('flagger.model'))->create();

        $feature = factory(Feature::class)->create();

        Flagger::flag($user, $feature->name);

        $this->assertTrue(Flagger::hasFeatureEnable($user, $feature->name));
        $this->assertFalse(Flagger::hasFeatureEnable($user, factory(Feature::class)->create()->name));
    }
}
