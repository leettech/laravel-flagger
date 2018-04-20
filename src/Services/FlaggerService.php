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
		$this->getFlaggableInstanceByFeatureName($feature)
            ->attach($flaggable->getKey());
	}

    public function flagMany($flaggables, $feature)
    {
        $this->getFlaggableInstanceByFeatureName($feature)
            ->attach($flaggables->pluck('id'));
    }

	public function hasFeatureEnabled(Model $flaggable, $feature)
	{
        return $this->getFlaggableInstanceByFeatureName($feature)
            ->where('flaggable_id', $flaggable->getKey())
            ->exists();
	}

    protected function getFlaggableInstanceByFeatureName($name)
    {
        return $this->feature
            ->where('name', $name)
            ->firstOrFail()
            ->flaggables();
    }
}
