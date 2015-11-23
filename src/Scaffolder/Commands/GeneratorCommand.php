<?php

namespace Scaffolder\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Scaffolder\Compilers\Core\ControllerCompiler;
use Scaffolder\Compilers\Core\MigrationCompiler;
use Scaffolder\Compilers\Core\ModelCompiler;
use Scaffolder\Compilers\Core\RouteCompiler;
use Scaffolder\Compilers\View\CreateViewCompiler;
use Scaffolder\Compilers\View\EditViewCompiler;
use Scaffolder\Compilers\View\IndexViewCompiler;
use Scaffolder\Compilers\View\PageLayoutCompiler;
use Scaffolder\Support\Directory;
use Scaffolder\Support\Json;
use Scaffolder\Themes\IScaffolderThemeLayouts;
use Scaffolder\Themes\IScaffolderThemeViews;

class GeneratorCommand extends Command
{
    protected $signature = 'mpaleo.scaffolder:generate';

    protected $description = 'Scaffold an application';

    protected $stubsDirectory;

    protected $themeViews;

    protected $themeLayouts;

    public function __construct(IScaffolderThemeViews $themeViews, IScaffolderThemeLayouts $themeLayouts)
    {
        parent::__construct();

        $this->themeViews = $themeViews;
        $this->themeLayouts = $themeLayouts;
        $this->stubsDirectory = __DIR__ . '/../../../stubs/'
    }

    /**
     * Execute the Command.
     */
    public function handle()
    {
        // Get all the models
        $modelFiles = File::allFiles(base_path('scaffolder-config/models/'));

        // Start progress bar
        $this->output->progressStart(count($modelFiles));

        // Get app config
        $scaffolderConfig = Json::decodeFile(base_path('scaffolder-config/app.json'));

        // Compilers
        $modelCompiler = new ModelCompiler();
        $migrationCompiler = new MigrationCompiler();
        $controllerCompiler = new ControllerCompiler();
        $indexViewCompiler = new IndexViewCompiler();
        $createViewCompiler = new CreateViewCompiler();
        $editViewCompiler = new EditViewCompiler();
        $pageLayoutViewCompiler = new PageLayoutCompiler();
        $routeCompiler = new RouteCompiler();

        // Compiler output
        $modelCompilerOutput = [];
        $controllerCompilerOutput = [];
        $viewCompilerOutput = [];
        $migrationCompilerOutput = [];

        // Sidenav links
        $sidenavLinks = [];

        // Compiled routes
        $compiledRoutes = '';

        // Get stubs
        $modelStub = File::get($this->stubsDirectory . 'Model.php');
        $migrationStub = File::get($this->stubsDirectory . 'Migration.php');
        $controllerStub = File::get($this->stubsDirectory . 'Controller.php');
        $indexViewStub = File::get($this->themeViews->getIndexPath());
        $createViewStub = File::get($this->themeViews->getCreatePath());
        $editViewStub = File::get($this->themeViews->getEditPath());
        $routeStub = File::get($this->stubsDirectory . 'ResourceRoute.php');

        // Create models directory
        Directory::createIfNotExists(app_path('Models'));

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
            array_push($modelCompilerOutput, $modelCompiler->compile($modelStub, $modelName, $modelData, $scaffolderConfig, $modelHash));
            array_push($controllerCompilerOutput, $controllerCompiler->compile($controllerStub, $modelName, $modelData, $scaffolderConfig, $modelHash));
            array_push($migrationCompilerOutput, $migrationCompiler->compile($migrationStub, $modelName, $modelData, $scaffolderConfig, $modelHash));
            array_push($viewCompilerOutput, $indexViewCompiler->compile($indexViewStub, $modelName, $modelData, $scaffolderConfig, $modelHash));
            array_push($viewCompilerOutput, $createViewCompiler->compile($createViewStub, $modelName, $modelData, $scaffolderConfig, $modelHash));
            array_push($viewCompilerOutput, $editViewCompiler->compile($editViewStub, $modelName, $modelData, $scaffolderConfig, $modelHash));
            $compiledRoutes .= $routeCompiler->compile($routeStub, $modelName, $modelData, $scaffolderConfig, null);

            // Add entity link
            array_push($sidenavLinks, $modelName);

            // Advance progress
            $this->output->progressAdvance();
        }

        // Store compiled routes
        $routeCompiler->compileGroup(File::get($this->stubsDirectory . 'Routes.php'), $compiledRoutes, $scaffolderConfig);

        // Create layouts directory
        Directory::createIfNotExists(base_path('resources/views/layouts'));

        // Store compiled page layout
        array_push($viewCompilerOutput, $pageLayoutViewCompiler->compile(File::get($this->themeLayouts->getPagePath()), null, null, $scaffolderConfig, null, ['links' => $sidenavLinks]));

        // Store create layout
        File::copy($this->themeLayouts->getCreatePath(), base_path('resources/views/layouts/create.blade.php'));
        array_push($viewCompilerOutput, base_path('resources/views/layouts/create.blade.php'));

        // Store edit layout
        File::copy($this->themeLayouts->getEditPath(), base_path('resources/views/layouts/edit.blade.php'));
        array_push($viewCompilerOutput, base_path('resources/views/layouts/edit.blade.php'));

        // Store dashboard
        File::copy($this->themeViews->getDashboardPath(), base_path('resources/views/dashboard.blade.php'));
        array_push($viewCompilerOutput, base_path('resources/views/dashboard.blade.php'));

        // Finish progress
        $this->output->progressFinish();

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
    }
}