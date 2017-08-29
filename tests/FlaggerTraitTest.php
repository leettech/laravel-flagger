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

        $featureNotInTheList = factory(Feature::class)->create();

        $this->assertArraySubset($features->toArray(), $user->features->toArray());
        $this->assertNotContains($user->features->toArray(), $featureNotInTheList->toArray());
    }
}
