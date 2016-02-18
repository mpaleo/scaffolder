<?php

namespace Scaffolder\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

abstract class BaseCommand extends Command
{
    /**
     * Store status in cache or print.
     *
     * @param string $status
     * @param bool $webExecution
     */
    protected function writeStatus($status, $webExecution)
    {
        if ($webExecution)
        {
            $cachedStatus = unserialize(Cache::get('scaffolder-status'));
            array_push($cachedStatus, $status);
            Cache::forever('scaffolder-status', serialize($cachedStatus));
        }
        else
        {
            $this->info($status);
        }
    }
}
