<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Leet\Flagger;
use Leet\Models\Feature;
use Tests\Stubs\User;

class FeatureFlagTest extends TestCase
{
    use DatabaseMigrations;

    public function testUserCanSeeFeature()
    {
        $user = factory(User::class)->create();

        $feature = factory(Feature::class)->create();

        Flagger::flag($user, $feature);

        $this->assertTrue(Flagger::canSee($user, $feature));
        $this->assertFalse(Flagger::canSee($user, factory(Feature::class)->create()));
    }

    public function testUserCanNotSeeFeature()
	{
        $user = factory(User::class)->create();

        $feature = factory(Feature::class)->create();

        Flagger::flag($user, $feature);

        $this->assertTrue(Flagger::canNotSee($user, factory(Feature::class)->create()));
        $this->assertFalse(Flagger::canNotSee($user, $feature));
	}
}
