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

        $request = $this->getMockRequest();

        (new FlaggerMiddleware)->handle($request, function() {}, $feature->name);
    }

    /**
     * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testFeatureNotFound()
    {
        $request = $this->getMockRequest();

        (new FlaggerMiddleware)->handle($request, function() {}, 'notifications');
    }

    public function testHasFeatureEnable()
    {
        $user = factory(config('flagger.model'))->create();

        $request = $this->getMockRequest($user);

        $feature = factory(Feature::class)->create();

        Flagger::flag($user, $feature->name);

        $response = (new FlaggerMiddleware)->handle($request, function() {
            return new Response;
        }, $feature->name);

        $this->assertInstanceOf(Response::class, $response);
    }

    protected function getMockRequest($user = null)
    {
        if (!$user) {
            $user = factory(config('flagger.model'))->create();
        }

        $request = Mockery::mock(Request::class);

        $request->shouldReceive('user')
            ->once()
            ->andReturn($user);

        return $request;
    }
}
