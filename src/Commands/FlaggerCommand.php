<?php

namespace Leet\Commands;

use Illuminate\Console\Command;
use Leet\Facades\Flagger;
use Leet\Services\FlaggerService;

class FlaggerCommand extends Command
{
    protected $signature = 'flagger
                            {feature : The feature name}
                            {targets* : List of users to flag}
                            {--chunk=100 : Size of flaggables blocks that will run}';

    protected $description = 'Flag users with a feature flag';

    public function handle(FlaggerService $flagger)
    {
        $feature = $this->argument('feature');

        $flaggables = $this->getFlaggables();

        if ($flaggables->count() == 1) {
            return $flagger->flag($flaggables->first(), $feature);
        }

        $progress = $this->output->createProgressBar($flaggables->count());

        $flaggables->chunk($this->option('chunk'), function ($flaggables) use ($flagger, $feature, $progress){
            $flagger->flagMany($flaggables, $feature);

            $progress->advance($flaggables->count());
        });

        $progress->finish();
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

        if ($csvPath = $this->getCsvPath($targets[0])) {
            $targets = $this->getIdsFromCsv($csvPath);
        }

        return $targets;
    }

    protected function getIdsFromCsv($file)
    {
        return fgetcsv(
            fopen($file, 'r')
        );
    }

    protected function getCsvPath($input)
    {
        return $this->isCsvFile($input) ? $input : null;
    }

    protected function isCsvFile($input)
    {
        return is_string($input) && is_file($input);
    }
}
