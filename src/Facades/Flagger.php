<?php

namespace Leet\Facades;

use Illuminate\Support\Facades\Facade;
use Leet\Services\FlaggerService;

class Flagger extends Facade
{
    protected static function getFacadeAccessor()
    {
        return FlaggerService::class;
    }
}
