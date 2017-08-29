<?php

namespace Leet\Models;

use Flagger;
use Leet\Models\Feature;

trait FlaggerTrait
{
    public function features()
    {
        return $this->morphToMany(Feature::class, 'flaggable');
    }

    public function flag($feature)
    {
        Flagger::flag($this, $feature);
    }

    public function hasFeatureEnabled($feature)
    {
        return Flagger::hasFeatureEnabled($this, $feature);
    }
}
