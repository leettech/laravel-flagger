<?php

namespace Leet\Middleware;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Flagger;

class FlaggerMiddleware
{
    public function handle($request, \Closure $next, $feature)
    {
        $user = $request->user();

        if (!$user) {
            throw new AuthenticationException;
        }

        if (!Flagger::hasFeatureEnabled($user, $feature)) {
            throw new AuthorizationException;
        }

        return $next($request);
    }
}
