<?php

namespace Leet\Services;

use Illuminate\Database\Eloquent\Model;
use Leet\Models\Feature;

class FlaggerService
{
	protected $feature;

    public function __construct(Feature $feature)
    {
        $this->feature = $feature;
    }

    public function flag(Model $flaggable, $feature)
	{
		$this->getFeatureByName($feature)
            ->flaggables()
            ->attach($flaggable->getKey());
	}

	public function hasFeatureEnable(Model $flaggable, $feature)
	{
        return $this->getFeatureByName($feature)
            ->flaggables()
            ->where('flaggable_id', $flaggable->getKey())
            ->exists();
	}

    protected function getFeatureByName($name)
    {
        return $this->feature
            ->where('name', $name)
            ->firstOrFail();
    }
}
