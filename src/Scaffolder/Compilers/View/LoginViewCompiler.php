<?php

namespace Scaffolder\Compilers\View;

use Illuminate\Support\Facades\File;
use Scaffolder\Compilers\AbstractViewCompiler;
use Scaffolder\Compilers\Support\FileToCompile;
use Scaffolder\Compilers\Support\PathParser;
use Scaffolder\Themes\ScaffolderThemeExtensionInterface;
use stdClass;

class LoginViewCompiler extends AbstractViewCompiler
{
    /**
     * Compiles the login view.
     *
     * @param $stub
     * @param $modelName
     * @param $modelData
     * @param \stdClass $scaffolderConfig
     * @param $hash
     * @param \Scaffolder\Themes\ScaffolderThemeExtensionInterface $themeExtension
     * @param null $extra
     *
     * @return string
     */
    public function compile($stub, $modelName, $modelData, stdClass $scaffolderConfig, $hash, ScaffolderThemeExtensionInterface $themeExtension, $extra = null)
    {
        $this->stub = $stub;

        return $this->store(null, $scaffolderConfig, $themeExtension->runAfterLoginViewIsCompiled($this->stub, $scaffolderConfig), new FileToCompile(null, null));
    }

    /**
     * Store the compiled stub.
     *
     * @param $modelName
     * @param \stdClass $scaffolderConfig
     * @param $compiled
     * @param \Scaffolder\Compilers\Support\FileToCompile $fileToCompile
     *
     * @return string
     */
    protected function store($modelName, stdClass $scaffolderConfig, $compiled, FileToCompile $fileToCompile)
    {
        $path = PathParser::parse($scaffolderConfig->paths->views) . 'login.blade.php';

        File::put($path, $compiled);

        return $path;
    }
}
