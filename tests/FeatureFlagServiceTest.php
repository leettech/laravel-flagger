<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Leet\FlaggerService;
use Leet\Models\Feature;
use Tests\Stubs\User;

class FeatureFlagServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function testUserCanSeeFeature()
    {
        $user = factory(User::class)->create();

        $feature = factory(Feature::class)->create();

        $service = new FlaggerService;

        $service->flag($user, $feature);

        $this->assertTrue($service->canSee($user, $feature));
        $this->assertFalse($service->canSee($user, factory(Feature::class)->create()));
    }

    public function testUserCanNotSeeFeature()
	{
        $user = factory(User::class)->create();

        $feature = factory(Feature::class)->create();

        $service = new FlaggerService;

		$service->flag($user, $feature);

        $this->assertTrue($service->canNotSee($user, factory(Feature::class)->create()));
        $this->assertFalse($service->canNotSee($user, $feature));
	}
}
