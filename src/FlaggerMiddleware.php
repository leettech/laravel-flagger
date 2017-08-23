<?php

namespace Leet;

use Illuminate\Auth\Access\AuthorizationException;

class FlaggerMiddleware
{
    public function handle($request, \Closure $next)
    {
        if (!$request->user()) {
            throw new AuthorizationException;
        }

        return $next($request);
    }
}
