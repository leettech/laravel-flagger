<?php

namespace Leet\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Feature extends Model
{
    public function flaggables()
    {
        return $this->morphedByMany(User::class, 'flaggable');
    }
}
