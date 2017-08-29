<?php

namespace Leet\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $hidden = [
        'pivot',
    ];

    protected $fillable = [
        'name',
        'description',
    ];

    public function flaggables()
    {
        return $this->morphedByMany(config('flagger.model'), 'flaggable')
            ->withTimestamps();
    }
}
