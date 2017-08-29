<?php

namespace Leet\Models;

use Leet\Flagger;

trait HasFeature
{
    public function hasFeatureEnable($feature)
    {
        return Flagger::hasFeatureEnable($this, $feature);
    }
}
