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

	public function canSee(Model $flaggable, Feature $feature)
	{
		return $feature->flaggables()
            ->where('flaggables.flaggable_id', $flaggable->id)
            ->exists();
	}

    public function canNotSee(Model $flaggable, Feature $feature)
    {
        return !$this->canSee($flaggable, $feature);
    }
}
