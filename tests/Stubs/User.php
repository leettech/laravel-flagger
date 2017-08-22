<?php

namespace Tests\Stubs;

use Leet\Models\Feature;

class User extends \Illuminate\Foundation\Auth\User
{
    public function features()
    {
        return $this->belongsToMany(Feature::class);
    }
}
