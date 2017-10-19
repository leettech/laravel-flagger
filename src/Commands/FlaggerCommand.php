<?php

namespace Leet\Commands;

use Illuminate\Console\Command;
use Leet\Facades\Flagger;

class FlaggerCommand extends Command
{
    protected $signature = 'flagger
                            {feature : The feature name}
                            {targets* : List of users to flag}';

    protected $description = 'Flag users with a feature flag';

    public function handle()
    {
        $feature = $this->argument('feature');

        $this->getFlaggables()
            ->each(function ($flaggable) use ($feature) {
                $this->flag($flaggable, $feature);
            });
    }

    protected function getFlaggables()
    {
        $flaggableIds = $this->getIdsFromArgument();

        $model = app(config('flagger.model'));

        $query = $model->newQuery();

        if (is_array($flaggableIds)) {
            return $query->whereIn('id', $flaggableIds);
        }

        return $query->where('id', $flaggableIds);
    }

    protected function getIdsFromArgument()
    {
        $targets = $this->argument('targets');

        if (is_string($targets) && is_file($targets)) {
            $targets = $this->getIdsFromCsv($targets);
        }

        return $targets;
    }

    protected function getIdsFromCsv($file)
    {
        return fgetcsv(
            fopen($file, 'r')
        );
    }

    protected function flag($flaggable, $feature)
    {
        Flagger::flag($flaggable, $feature);
    }
}
