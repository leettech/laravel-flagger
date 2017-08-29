<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Leet\Models\Feature;

class FlaggerTraitTest extends TestCase
{
    use DatabaseMigrations;

    public function testFeaturesRelationship()
    {
        $user = factory(config('flagger.model'))->create();

        $features = factory(Feature::class, 5)
            ->create()
            ->each(function ($feature) use ($user) {
                $user->flag($feature->name);
            });

        factory(Feature::class)->create();

        $this->assertCount(5, $user->features);
        $this->assertArraySubset($features->toArray(), $user->features->toArray());
    }

    public function testFlag()
    {
        $user = factory(config('flagger.model'))->create();

        $feature = factory(Feature::class)->create();

        try {
            $user->flag($feature->name);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testHasFeatureEnable()
    {
        $user = factory(config('flagger.model'))->create();

        $feature = factory(Feature::class)->create();

        $user->flag($feature->name);

        $this->assertTrue($user->hasFeatureEnable($feature->name));
        $this->assertFalse($user->hasFeatureEnable(factory(Feature::class)->create()->name));
    }
}
