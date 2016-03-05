<?php

namespace Scaffolder\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ClearCacheCommand extends Command
{
    /**
     * Command signature.
     * @var string
     */
    protected $signature = 'scaffolder:cache-clear';

    /**
     * Command description.
     * @var string
     */
    protected $description = 'Delete compiled files';

    /**
     * Execute the command.
     */
    public function handle()
    {
        try
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
        catch (\Exception $exception)
        {
            Log::error($exception->getMessage());
        }
    }
}
