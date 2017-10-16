<?php

namespace Leet\Commands;

use Illuminate\Console\Command;
use Leet\Facades\Flagger;

class FlaggerCommand extends Command
{
    protected $signature = 'flagger
                            {feature : The feature name}
                            {source* : List of users to flag}';

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
        $source = $this->getSource();

        $model = app(config('flagger.model'));

        $query = $model->newQuery();

        if (is_array($source)) {
            return $query->whereIn('id', $source);
        }

        return $query->where('id', $source);
    }

    protected function getSource()
    {
        $source = $this->argument('source');

        if (is_string($source) && is_file($source)) {
            $file = fopen($source, 'r');

            return fgetcsv($file);
        }

        return $source;
    }

    protected function flag($flaggable, $feature)
    {
        Flagger::flag($flaggable, $feature);
    }
}
