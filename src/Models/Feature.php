<?php

namespace Leet\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    public function flaggables()
    {
        return $this->morphedByMany(config('flagger.model'), 'flaggable');
    }

    public function findByName($name)
    {
        return $this->where('name', $name)
            ->firstOrFail();
    }

    public function attachFlaggable(Model $flaggable)
    {
        $this->flaggables()
            ->attach($flaggable->getKey());
    }

    public function existsFlaggable(Model $flaggable)
    {
        return $this->flaggables()
            ->where('flaggable_id', $flaggable->getKey())
            ->exists();
    }
}
