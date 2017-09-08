<?php

namespace Leet\Commands;

use Illuminate\Console\Command;
use Leet\Facades\Flagger;

class FlaggerCommand extends Command
{
    protected $signature = 'flagger {feature} {ids*}';

    public function handle()
    {
        $feature = $this->argument('feature');

        $ids = $this->argument('ids');

        $this->getFlaggables($ids)
            ->each(function ($flaggable) use ($feature) {
                $this->flag($flaggable, $feature);
            });
    }

    protected function getFlaggables($ids)
    {
        $model = app(config('flagger.model'));

        $query = $model->newQuery();

        if (is_array($ids)) {
            return $query->whereIn('id', $ids);
        }

        return $query->where('id', $ids);
    }

    protected function flag($flaggable, $feature)
    {
        Flagger::flag($flaggable, $feature);
    }
}
