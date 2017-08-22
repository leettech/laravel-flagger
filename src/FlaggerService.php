<?php

namespace Leet;

use Leet\Models\Feature;
use Tests\Stubs\User;

class FlaggerService
{
	public function flag(User $user, Feature $feature)
	{
		$user->features()
            ->attach($feature->id);
	}

	public function canSee(User $user, Feature $feature)
	{
		return $user->features()
            ->where('features.id', $feature->id)
            ->exists();
	}

    public function canNotSee(User $user, Feature $feature)
    {
        return !$this->canSee($user, $feature);
    }
}
