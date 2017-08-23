<?php

namespace Leet;

use Illuminate\Database\Eloquent\Model;
use Leet\Models\Feature;

class FlaggerService
{
	public function flag(Model $flaggable, Feature $feature)
	{
		$feature->flaggables()
            ->attach($flaggable->id);
	}

	public function canSee(Model $flaggable, $feature)
	{
        $feature = Feature::where('name', $feature)
            ->firstOrFail();

		return $feature->flaggables()
            ->where('flaggables.flaggable_id', $flaggable->id)
            ->exists();
	}

    public function canNotSee(Model $flaggable, $feature)
    {
        return !$this->canSee($flaggable, $feature);
    }
}
