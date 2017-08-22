<?php

namespace Leet;

use Illuminate\Support\Facades\Facade;
use Leet\FlaggerService;

class Flagger extends Facade
{
    protected static function getFacadeAccessor()
    {
        return FlaggerService::class;
    }
}
