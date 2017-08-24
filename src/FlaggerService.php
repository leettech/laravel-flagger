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
            ->attachFlaggable($flaggable);
	}

	public function hasFeatureEnable(Model $flaggable, $feature)
	{
        return $this->getFeatureByName($feature)
            ->existsFlaggable($flaggable);
	}

    protected function getFeatureByName($name)
    {
        return $this->feature
            ->findByName($name);
    }
}
