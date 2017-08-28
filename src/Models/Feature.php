<?php

namespace Leet\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    public function flaggables()
    {
        return $this->morphedByMany(config('flagger.model'), 'flaggable')
            ->withTimestamps();
    }
}
