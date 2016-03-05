<?php

namespace Scaffolder\Commands;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Scaffolder\Compilers\Core\Api\ApiControllerCompiler;
use Scaffolder\Compilers\Core\Api\ApiModelCompiler;
use Scaffolder\Compilers\Core\Api\ApiRouteCompiler;
use Scaffolder\Compilers\Core\ControllerCompiler;
use Scaffolder\Compilers\Core\MigrationCompiler;
use Scaffolder\Compilers\Core\ModelCompiler;
use Scaffolder\Compilers\Core\RouteCompiler;
use Scaffolder\Compilers\Layout\CreateLayoutCompiler;
use Scaffolder\Compilers\Layout\EditLayoutCompiler;
use Scaffolder\Compilers\Layout\PageLayoutCompiler;
use Scaffolder\Compilers\View\CreateViewCompiler;
use Scaffolder\Compilers\View\DashboardViewCompiler;
use Scaffolder\Compilers\View\EditViewCompiler;
use Scaffolder\Compilers\View\IndexViewCompiler;
use Scaffolder\Compilers\View\LoginViewCompiler;
use Scaffolder\Compilers\View\WelcomeViewCompiler;
use Scaffolder\Support\Contracts\ScaffolderExtensionInterface;
use Scaffolder\Support\Contracts\ScaffolderThemeExtensionInterface;
use Scaffolder\Support\Contracts\ScaffolderThemeLayoutsInterface;
use Scaffolder\Support\Contracts\ScaffolderThemeViewsInterface;
use Scaffolder\Support\Directory;
use Scaffolder\Support\Json;

class GeneratorCommand extends BaseCommand
{
    /**
     * Command signature.
     * @var string
     */
    protected $signature = 'scaffolder:generate {--api} {--webExecution}';

    /**
     * Command description.
     * @var string
     */
    protected $description = 'Scaffold an application';

    /**
     * Stubs directory.
     * @var string
     */
    protected $stubsDirectory;

    /**
     * Theme views implementation.
     * @var \Scaffolder\Support\Contracts\ScaffolderThemeViewsInterface
     */
    protected $themeViews;

    /**
     * Theme layouts implementation.
     * @var \Scaffolder\Support\Contracts\ScaffolderThemeLayoutsInterface
     */
    protected $themeLayouts;

    /**
     * Theme extension implementation.
     * @var \Scaffolder\Support\Contracts\ScaffolderThemeExtensionInterface
     */
    protected $themeExtension;

    /**
     * Extension implementations.
     * @var \Scaffolder\Support\Contracts\ScaffolderExtensionInterface[]
     */
    protected $extensions;

    /**
     * Create a new generator command instance.
     *
     * @param \Scaffolder\Support\Contracts\ScaffolderThemeViewsInterface $themeViews
     * @param \Scaffolder\Support\Contracts\ScaffolderThemeLayoutsInterface $themeLayouts
     * @param \Scaffolder\Support\Contracts\ScaffolderThemeExtensionInterface $themeExtension
     * @param \Scaffolder\Support\Contracts\ScaffolderExtensionInterface[] $extensions
     *
     * @throws \Exception
     */
    public function __construct(ScaffolderThemeViewsInterface $themeViews, ScaffolderThemeLayoutsInterface $themeLayouts, ScaffolderThemeExtensionInterface $themeExtension, array $extensions)
    {
        parent::__construct();

        foreach ($extensions as $extension)
        {
            if (!$extension instanceof ScaffolderExtensionInterface)
            {
                throw new \Exception('Scaffolder extensions must implement \Scaffolder\Support\Contracts\ScaffolderExtensionInterface');
            }
        }

        $this->themeViews = $themeViews;
        $this->themeLayouts = $themeLayouts;
        $this->themeExtension = $themeExtension;
        $this->extensions = $extensions;
        $this->stubsDirectory = __DIR__ . '/../../../stubs/';
    }

    /**
     * Execute the Command.
     */
    public function handle()
    {
        $scaffoldApi = $this->option('api');
        $webExecution = $this->option('webExecution');

        try
        {
            // Get all the models
            $modelFiles = File::allFiles(base_path('scaffolder-config/models/'));

            // Get app config
            $scaffolderConfig = Json::decodeFile(base_path('scaffolder-config/app.json'));

            $apiDirectory = strtolower(str_replace(' ', '-', $scaffolderConfig->name . '-api'));

            // Compilers
            $modelCompiler = new ModelCompiler();
            $apiModelCompiler = new ApiModelCompiler();
            $migrationCompiler = new MigrationCompiler();
            $controllerCompiler = new ControllerCompiler();
            $apiControllerCompiler = new ApiControllerCompiler();
            $indexViewCompiler = new IndexViewCompiler();
            $createViewCompiler = new CreateViewCompiler();
            $editViewCompiler = new EditViewCompiler();
            $dashboardViewCompiler = new DashboardViewCompiler();
            $welcomeViewCompiler = new WelcomeViewCompiler();
            $loginViewCompiler = new LoginViewCompiler();
            $pageLayoutViewCompiler = new PageLayoutCompiler();
            $createLayoutCompiler = new CreateLayoutCompiler();
            $editLayoutCompiler = new EditLayoutCompiler();
            $routeCompiler = new RouteCompiler();
            $apiRouteCompiler = new ApiRouteCompiler();

            // Compiler output
            $modelCompilerOutput = [];
            $apiModelCompilerOutput = [];
            $controllerCompilerOutput = [];
            $apiControllerCompilerOutput = [];
            $viewCompilerOutput = [];
            $migrationCompilerOutput = [];

            // Sidenav links
            $sidenavLinks = [];

            // Compiled routes
            $compiledRoutes = '';
            $compiledApiRoutes = '';

            // Get stubs
            $modelStub = File::get($this->stubsDirectory . 'Model.php');
            $apiModelStub = File::get($this->stubsDirectory . 'api/Model.php');
            $migrationStub = File::get($this->stubsDirectory . 'Migration.php');
            $controllerStub = File::get($this->stubsDirectory . 'Controller.php');
            $apiControllerStub = File::get($this->stubsDirectory . 'api/Controller.php');
            $indexViewStub = File::get($this->themeViews->getIndexPath());
            $createViewStub = File::get($this->themeViews->getCreatePath());
            $editViewStub = File::get($this->themeViews->getEditPath());
            $routeStub = File::get($this->stubsDirectory . 'ResourceRoute.php');
            $apiRouteStub = File::get($this->stubsDirectory . 'api/ResourceRoute.php');

            // Create models directory
            Directory::createIfNotExists(app_path('Models'));

            // Initialize API
            if ($scaffoldApi)
            {
                if (!(new \FilesystemIterator(base_path('../' . $apiDirectory)))->valid())
                {
                    $this->writeStatus('Initializing API ...', $webExecution);

                    $this->call('scaffolder:api-initialize', [
                        'name' => $scaffolderConfig->name,
                        'domain' => $scaffolderConfig->api->domain,
                        '--webExecution' => $webExecution
                    ]);

                    $this->output->newLine();
                }
                else
                {
                    $this->writeStatus('API already initialized', $webExecution);
                }

                // Create models directory
                Directory::createIfNotExists(base_path('../' . $apiDirectory . '/app/Models'));
            }

            $this->writeStatus('Compiling ...', $webExecution);
            $this->output->newLine();

            // Start progress bar
            $this->output->progressStart(count($modelFiles));

            // Iterate over model files
            foreach ($modelFiles as $modelFile)
            {
                // Get model name
                $modelName = ucwords($modelFile->getBasename('.' . $modelFile->getExtension()));

                // Get model data
                $modelData = Json::decodeFile($modelFile->getRealPath());

                // Create views directory
                Directory::createIfNotExists(base_path('resources/views/' . strtolower($modelName)));

                $modelHash = md5_file($modelFile->getRealPath());

                // Compile stubs
                array_push($modelCompilerOutput, $modelCompiler->compile($modelStub, $modelName, $modelData, $scaffolderConfig, $modelHash, $this->extensions));
                if ($scaffoldApi) array_push($apiModelCompilerOutput, $apiModelCompiler->compile($apiModelStub, $modelName, $modelData, $scaffolderConfig, $modelHash, $this->extensions));
                array_push($controllerCompilerOutput, $controllerCompiler->compile($controllerStub, $modelName, $modelData, $scaffolderConfig, $modelHash, $this->extensions));
                if ($scaffoldApi) array_push($apiControllerCompilerOutput, $apiControllerCompiler->compile($apiControllerStub, $modelName, $modelData, $scaffolderConfig, $modelHash, $this->extensions));
                array_push($migrationCompilerOutput, $migrationCompiler->compile($migrationStub, $modelName, $modelData, $scaffolderConfig, $modelHash, $this->extensions));
                array_push($viewCompilerOutput, $indexViewCompiler->compile($indexViewStub, $modelName, $modelData, $scaffolderConfig, $modelHash, $this->themeExtension, $this->extensions));
                array_push($viewCompilerOutput, $createViewCompiler->compile($createViewStub, $modelName, $modelData, $scaffolderConfig, $modelHash, $this->themeExtension, $this->extensions));
                array_push($viewCompilerOutput, $editViewCompiler->compile($editViewStub, $modelName, $modelData, $scaffolderConfig, $modelHash, $this->themeExtension, $this->extensions));
                $compiledRoutes .= $routeCompiler->compile($routeStub, $modelName, $modelData, $scaffolderConfig, null, $this->extensions);
                if ($scaffoldApi) $compiledApiRoutes .= $apiRouteCompiler->compile($apiRouteStub, $modelName, $modelData, $scaffolderConfig, null, $this->extensions);

                // Add entity link
                array_push($sidenavLinks, ['modelName' => $modelName, 'modelLabel' => $modelData->modelLabel]);

                // Advance progress
                $this->output->progressAdvance();
            }

            // Finish progress
            $this->output->progressFinish();

            // Store compiled routes
            $routeCompiler->compileGroup(File::get($this->stubsDirectory . 'Routes.php'), $compiledRoutes, $scaffolderConfig);
            if ($scaffoldApi) $apiRouteCompiler->compileGroup(File::get($this->stubsDirectory . 'api/Routes.php'), $compiledApiRoutes, $scaffolderConfig);

            // Create layouts directory
            Directory::createIfNotExists(base_path('resources/views/layouts'));

            // Compile page layout
            array_push($viewCompilerOutput, $pageLayoutViewCompiler->compile(File::get($this->themeLayouts->getPagePath()), null, null, $scaffolderConfig, null, $this->themeExtension, $this->extensions, ['links' => $sidenavLinks]));

            // Compile create layout
            array_push($viewCompilerOutput, $createLayoutCompiler->compile(File::get($this->themeLayouts->getCreatePath()), null, null, $scaffolderConfig, null, $this->themeExtension, $this->extensions));

            // Compile edit layout
            array_push($viewCompilerOutput, $editLayoutCompiler->compile(File::get($this->themeLayouts->getEditPath()), null, null, $scaffolderConfig, null, $this->themeExtension, $this->extensions));

            // Compile dashboard view
            array_push($viewCompilerOutput, $dashboardViewCompiler->compile(File::get($this->themeViews->getDashboardPath()), null, null, $scaffolderConfig, null, $this->themeExtension, $this->extensions));

            // Compile welcome view
            array_push($viewCompilerOutput, $welcomeViewCompiler->compile(File::get($this->themeViews->getWelcomePath()), null, null, $scaffolderConfig, null, $this->themeExtension, $this->extensions));

            // Compile login view
            array_push($viewCompilerOutput, $loginViewCompiler->compile(File::get($this->themeViews->getLoginPath()), null, null, $scaffolderConfig, null, $this->themeExtension, $this->extensions));

            // Summary
            $this->comment('- Files created');

            $this->comment('- - Views');
            foreach ($viewCompilerOutput as $viewFile)
            {
                $this->info('- - - ' . $viewFile);
            }

            $this->comment('- - Controllers');
            foreach ($controllerCompilerOutput as $controllerFile)
            {
                $this->info('- - - ' . $controllerFile);
            }

            $this->comment('- - Migrations');
            foreach ($migrationCompilerOutput as $migrationFile)
            {
                $this->info('- - - ' . $migrationFile);
            }

            $this->comment('- - Models');
            foreach ($modelCompilerOutput as $modelFile)
            {
                $this->info('- - - ' . $modelFile);
            }

            if ($scaffoldApi)
            {
                $this->comment('- - API Controllers');
                foreach ($apiControllerCompilerOutput as $apiControllerFile)
                {
                    $this->info('- - - ' . $apiControllerFile);
                }

                $this->comment('- - API Models');
                foreach ($apiModelCompilerOutput as $apiModelFile)
                {
                    $this->info('- - - ' . $apiModelFile);
                }
            }

            $this->writeStatus('Done', $webExecution);
        }
        catch (\Exception $exception)
        {
            $this->writeStatus('Error', $webExecution);
            Log::error($exception->getMessage());
        }
    }
}
