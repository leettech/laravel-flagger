<?php

namespace Leet\Commands;

use Illuminate\Console\Command;
use Leet\Facades\Flagger;

class FlaggerCommand extends Command
{
    protected $signature = 'flagger {feature} {ids*}';

    protected $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = app(config('flagger.model'));
    }

    public function handle()
    {
        $feature = $this->argument('feature');

        $ids = $this->argument('ids');

        if (is_array($ids)) {
            $this->model
                ->whereIn('id', $ids)
                ->each(function ($flaggable) use ($feature){
                    $this->flag($flaggable, $feature);
                });
        } else {
            $flaggable = $this->model->findOrFail($ids);

            $this->flag($flaggable, $feature);
        }
    }

    protected function flag($flaggable, $feature)
    {
        Flagger::flag($flaggable, $feature);
    }
}
