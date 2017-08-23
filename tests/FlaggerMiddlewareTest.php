<?php

namespace Tests;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Leet\FlaggerMiddleware;
use Tests\TestCase;

class FlaggerMiddlewareTest extends TestCase
{
    /**
     * @expectedException Illuminate\Auth\Access\AuthorizationException
     */
    public function testUserNotAuthenticated()
    {
        (new FlaggerMiddleware)->handle(new Request, function() {});
    }
}
