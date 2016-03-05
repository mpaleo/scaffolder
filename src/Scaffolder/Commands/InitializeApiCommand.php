<?php

namespace Scaffolder\Commands;

use Illuminate\Support\Facades\File;
use Scaffolder\Support\Composer;

class InitializeApiCommand extends BaseCommand
{
    /**
     * Command signature.
     * @var string
     */
    protected $signature = 'scaffolder:api-initialize {name} {domain} {--webExecution}';

    /**
     * Command description.
     * @var string
     */
    protected $description = 'Initialize API project';

    /**
     * Execute the command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $domain = $this->argument('domain');
        $webExecution = $this->option('webExecution');

        try
        {
            $workingPath = base_path('../');
            $outputFolder = strtolower(str_replace(' ', '-', $name . '-api'));

            $this->writeStatus('Installing lumen and dependencies ...', $webExecution);

            // Create project
            (new Composer($workingPath))->createProject('laravel/lumen', '5.1.*', $outputFolder)
                ->setWorkingPath($workingPath . $outputFolder)
                ->requirePackage('dingo/api', '1.0.x@dev');

            $this->writeStatus('Setting up lumen ...', $webExecution);

            // Rename .env file
            File::move($workingPath . $outputFolder . '/.env.example', $workingPath . $outputFolder . '/.env');

            // Dingo config
            File::append($workingPath . $outputFolder . '/.env',
                'API_DOMAIN=' . $domain . PHP_EOL .
                'API_STANDARDS_TREE=vnd' . PHP_EOL .
                'API_SUBTYPE=' . strtolower(str_replace(' ', '', $name)) . PHP_EOL .
                'API_VERSION=v1' . PHP_EOL .
                'API_NAME="' . $name . '"' . PHP_EOL .
                'API_CONDITIONAL_REQUEST=false' . PHP_EOL .
                'API_STRICT=false' . PHP_EOL .
                'API_DEFAULT_FORMAT=json' . PHP_EOL .
                'API_DEBUG=true');

            // Get lumen app file
            $lumenAppFile = File::get($workingPath . $outputFolder . '/bootstrap/app.php');

            // Get .env file
            $lumenEnvFile = File::get($workingPath . $outputFolder . '/.env');

            // Enable Dotenv
            $lumenAppFile = str_replace('// Dotenv::load(__DIR__.\'/../\');', 'Dotenv::load(__DIR__.\'/../\');', $lumenAppFile);

            // Enable Eloquent
            $lumenAppFile = str_replace('// $app->withEloquent();', '$app->withEloquent();', $lumenAppFile);

            // Add Dingo service provider
            $registerServiceProviderPosition = strpos($lumenAppFile, 'Register Service Providers');
            $lumenAppFile = substr($lumenAppFile, 0, $registerServiceProviderPosition + 322) . '$app->register(Dingo\Api\Provider\LumenServiceProvider::class);' . substr($lumenAppFile, $registerServiceProviderPosition + 320);

            // Database config
            $lumenEnvFile = str_replace('DB_DATABASE=homestead', 'DB_DATABASE=' . env('DB_DATABASE', 'homestead'), $lumenEnvFile);
            $lumenEnvFile = str_replace('DB_USERNAME=homestead', 'DB_USERNAME=' . env('DB_USERNAME', 'homestead'), $lumenEnvFile);
            $lumenEnvFile = str_replace('DB_PASSWORD=secret', 'DB_PASSWORD=' . env('DB_PASSWORD', 'secret'), $lumenEnvFile);

            File::put($workingPath . $outputFolder . '/.env', $lumenEnvFile);
            File::put($workingPath . $outputFolder . '/bootstrap/app.php', $lumenAppFile);
        }
        catch (\Exception $exception)
        {
            $this->writeStatus('Error', $webExecution);
        }
    }
}
