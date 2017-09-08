<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Leet\Facades\Flagger;
use Leet\Models\Feature;

class FlaggerCommandTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();

        $this->feature = factory(Feature::class)->create();
    }

    public function testFlagSingleUser()
    {
        $user = factory(config('flagger.model'))->create();

        $this->artisan('flagger',[
            'feature' => $this->feature->name,
            'ids' => $user->id,
        ]);

        $this->assertTrue(Flagger::hasFeatureEnabled($user, $this->feature->name));
    }

    public function testFlagMultipleUsers()
    {
        $users = factory(config('flagger.model'), 10)->create();

        $this->artisan('flagger',[
            'feature' => $this->feature->name,
            'ids' => $users->pluck('id'),
        ]);

        foreach ($users as $user) {
            $this->assertTrue(Flagger::hasFeatureEnabled($user, $this->feature->name));
        }
    }
}
