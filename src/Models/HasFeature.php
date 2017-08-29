<?php

namespace Leet\Models;

use Flagger;

trait HasFeature
{
    public function hasFeatureEnable($feature)
    {
        return Flagger::hasFeatureEnable($this, $feature);
    }
}
