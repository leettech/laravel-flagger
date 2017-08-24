<?php

namespace Leet;

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
            ->attach($flaggable->id);
	}

	public function hasFeatureEnable(Model $flaggable, $feature)
	{
        return $this->getFeatureByName($feature)
            ->flaggables()
            ->where('flaggables.flaggable_id', $flaggable->id)
            ->exists();
	}

    protected function getFeatureByName($name)
    {
        return $this->feature
            ->where('name', $name)
            ->firstOrFail();
    }
}
