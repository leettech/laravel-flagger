<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Flagger;
use Leet\Middleware\FlaggerMiddleware;
use Leet\Models\Feature;
use Tests\TestCase;
use Mockery;

class FlaggerMiddlewareTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(config('flagger.model'))->create();

        $this->request = Mockery::mock(Request::class);

        $this->request->shouldReceive('user')
            ->andReturn($this->user);
    }

    /**
     * @expectedException Illuminate\Auth\AuthenticationException
     */
    public function testUserNotAuthenticated()
    {
        (new FlaggerMiddleware)->handle(new Request, function() {}, 'notifications');
    }

    /**
     * @expectedException Illuminate\Auth\Access\AuthorizationException
     */
    public function testUserNotAuthorized()
    {
        $feature = factory(Feature::class)->create();

        (new FlaggerMiddleware)->handle($this->request, function() {}, $feature->name);
    }

    /**
     * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testFeatureNotFound()
    {
        (new FlaggerMiddleware)->handle($this->request, function() {}, 'notifications');
    }

    public function testHasFeatureEnabled()
    {
        $feature = factory(Feature::class)->create();

        Flagger::flag($this->user, $feature->name);

        $response = (new FlaggerMiddleware)->handle($this->request, function() {
            return new Response;
        }, $feature->name);

        $this->assertInstanceOf(Response::class, $response);
    }
}
