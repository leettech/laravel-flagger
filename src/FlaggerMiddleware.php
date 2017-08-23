<?php

namespace Leet;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Leet\Models\Feature;

class FlaggerMiddleware
{
    public function handle($request, \Closure $next, $feature)
    {
        $user = $request->user();

        if (!$user) {
            throw new AuthenticationException;
        }

        if (!Flagger::hasFeatureEnable($user, $feature)) {
            throw new AuthorizationException;
        }

        return $next($request);
    }
}
