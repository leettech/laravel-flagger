<?php

namespace Leet\Commands;

use Illuminate\Console\Command;
use Leet\Facades\Flagger;

class FlaggerCommand extends Command
{
    protected $signature = 'flagger {feature} {source*}';

    public function handle()
    {
        $feature = $this->argument('feature');

        $source = $this->argument('source');

        $this->getFlaggables($source)
            ->each(function ($flaggable) use ($feature) {
                $this->flag($flaggable, $feature);
            });
    }

    protected function getFlaggables($source)
    {
        $model = app(config('flagger.model'));

        $query = $model->newQuery();

        if (is_array($source)) {
            return $query->whereIn('id', $source);
        }

        if (is_file($source)) {
            $file = fopen($source, 'r');

            return $query->whereIn('id', fgetcsv($file));
        }

        return $query->where('id', $source);
    }

    protected function flag($flaggable, $feature)
    {
        Flagger::flag($flaggable, $feature);
    }
}
