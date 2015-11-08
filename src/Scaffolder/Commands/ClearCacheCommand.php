<?php

namespace Scaffolder\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearCacheCommand extends Command
{
    protected $signature = 'mpaleo.scaffolder:cache:clear';

    protected $description = 'Delete the compiled files';

    /**
     * Execute the command.
     */
    public function handle()
    {
        // Get the compiled files
        $compiledFiles = File::glob(base_path('scaffolder-config/cache/*.scf'));

        // Start progress bar
        $this->output->progressStart(count($compiledFiles));

        foreach ($compiledFiles as $compiledFile)
        {
            File::delete($compiledFile);

            // Advance progress
            $this->output->progressAdvance();
        }

        // Finish progress
        $this->output->progressFinish();

        $this->info('Cache cleared');
    }
}