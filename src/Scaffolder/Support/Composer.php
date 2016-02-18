<?php

namespace Scaffolder\Support;

use Illuminate\Support\Facades\File;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessUtils;

class Composer
{
    /**
     * Working path.
     * @var string
     */
    protected $workingPath;

    /**
     * Create a new Composer wrapper instance.
     *
     * @param  string|null $workingPath
     */
    public function __construct($workingPath = null)
    {
        $this->workingPath = $workingPath;
    }

    /**
     * Composer create-project.
     *
     * @param $packageName
     * @param $packageVersion
     * @param $outputFolder
     *
     * @return $this
     */
    public function createProject($packageName, $packageVersion, $outputFolder)
    {
        $this->runCommand('create-project --prefer-dist ' . $packageName . ' ' . $outputFolder . ' "' . $packageVersion . '"');

        return $this;
    }

    /**
     * Composer require.
     *
     * @param $packageName
     * @param $packageVersion
     *
     * @return $this
     */
    public function requirePackage($packageName, $packageVersion)
    {
        $this->runCommand('require --prefer-dist ' . $packageName . ':' . $packageVersion);

        return $this;
    }

    /**
     * Composer dump-autoload.
     */
    public function dumpAutoload()
    {
        $this->runCommand('dump-autoload');

        return $this;
    }

    /**
     * Find composer.
     * @return string
     */
    protected function find()
    {
        if (!File::exists($this->workingPath . '/composer.phar'))
        {
            return 'composer';
        }

        $binary = ProcessUtils::escapeArgument((new PhpExecutableFinder)->find(false));

        if (defined('HHVM_VERSION'))
        {
            $binary .= ' --php';
        }

        return "{$binary} composer.phar";
    }

    /**
     * Get a new process instance.
     * @return \Symfony\Component\Process\Process
     */
    protected function getProcess()
    {
        return (new Process('', $this->workingPath))->setTimeout(null);
    }

    /**
     * Run composer command.
     *
     * @param $command
     *
     * @return $this
     */
    protected function runCommand($command)
    {
        $process = $this->getProcess();

        $process->setCommandLine(trim($this->find() . ' ' . $command));

        $process->run();

        return $this;
    }

    /**
     * Set the working path used.
     *
     * @param  string $path
     *
     * @return $this
     */
    public function setWorkingPath($path)
    {
        $this->workingPath = $path;

        return $this;
    }
}
