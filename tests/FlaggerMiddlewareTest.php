<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Leet\Flagger;
use Leet\FlaggerMiddleware;
use Leet\Models\Feature;
use Tests\TestCase;

class FlaggerMiddlewareTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @expectedException Illuminate\Auth\AuthenticationException
     */
    public function testUserNotAuthenticated()
    {
        (new FlaggerMiddleware)->handle(new Request, function() {}, 'notification');
    }

    /**
     * @expectedException Illuminate\Auth\Access\AuthorizationException
     */
    public function testUserNotAuthorized()
    {
        $user = factory(config('flagger.model'))->create();

        $feature = factory(Feature::class)->create();

        $request = \Mockery::mock(Request::class);

        $request->shouldReceive('user')
            ->once()
            ->andReturn($user);

        (new FlaggerMiddleware)->handle($request, function() {}, $feature->name);
    }

    /**
     * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testFeatureNotFound()
    {
        $user = factory(config('flagger.model'))->create();

        $request = \Mockery::mock(Request::class);

        $request->shouldReceive('user')
            ->once()
            ->andReturn($user);

        (new FlaggerMiddleware)->handle($request, function() {}, 'notification');
    }

    public function testUserCanSeeFeature()
    {
        $user = factory(config('flagger.model'))->create();

        $feature = factory(Feature::class)->create();

        Flagger::flag($user, $feature->name);

        $request = \Mockery::mock(Request::class);

        $request->shouldReceive('user')
            ->once()
            ->andReturn($user);

        $response = new Response;

        $response = (new FlaggerMiddleware)->handle($request, function() use ($response) {
            return $response;
        }, $feature->name);

        $this->assertInstanceOf(Response::class, $response);
    }
}
