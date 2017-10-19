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

        $this->users = factory(config('flagger.model'), 10)->create();
    }

    /**
     * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testFlagWithFeatureNotFound()
    {
        $user = $this->users->first();;

        $this->artisan('flagger',[
            'feature' => 'notifications',
            'targets' => $user->id,
        ]);
    }

    public function testFlagSingleUser()
    {
        $user = $this->users->first();;

        $this->artisan('flagger',[
            'feature' => $this->feature->name,
            'targets' => $user->id,
        ]);

        $this->assertTrue(Flagger::hasFeatureEnabled($user, $this->feature->name));
    }

    public function testFlagMultipleUsers()
    {
        $this->artisan('flagger',[
            'feature' => $this->feature->name,
            'targets' => $this->users->pluck('id'),
        ]);

        foreach ($this->users as $user) {
            $this->assertTrue(Flagger::hasFeatureEnabled($user, $this->feature->name));
        }
    }

    public function testFlagInvalidFlaggable()
    {
        $invalidId = 11;

        $targets = $this->users
            ->take(4)
            ->pluck('id')
            ->push($invalidId);

        $this->artisan('flagger',[
            'feature' => $this->feature->name,
            'targets' => $targets,
        ]);

        $this->assertCount(4, $this->feature->flaggables);
    }

    public function testFlagMultipleUsersByCsvFile()
    {
        $path = __DIR__ . '/tmp/users.csv';

        $this->makeUsersCsv($path);

        $this->artisan('flagger',[
            'feature' => $this->feature->name,
            'targets' => $path,
        ]);

        foreach ($this->users as $user) {
            $this->assertTrue(Flagger::hasFeatureEnabled($user, $this->feature->name));
        }
    }

    protected function makeUsersCsv($path)
    {
        $file = fopen($path, 'w');

        fputcsv($file, $this->users->pluck('id')->all());

        fclose($file);
    }
}
