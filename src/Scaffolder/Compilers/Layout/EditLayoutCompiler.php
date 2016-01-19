<?php

namespace Scaffolder\Compilers\Layout;

use Illuminate\Support\Facades\File;
use Scaffolder\Compilers\AbstractViewCompiler;
use Scaffolder\Support\Contracts\ScaffolderThemeExtensionInterface;
use Scaffolder\Support\FileToCompile;
use Scaffolder\Support\PathParser;
use stdClass;

class EditLayoutCompiler extends AbstractViewCompiler
{
    /**
     * Compiles the edit layout.
     *
     * @param $stub
     * @param $modelName
     * @param $modelData
     * @param \stdClass $scaffolderConfig
     * @param $hash
     * @param \Scaffolder\Support\Contracts\ScaffolderThemeExtensionInterface $themeExtension
     * @param \Scaffolder\Support\Contracts\ScaffolderExtensionInterface[] $extensions
     * @param null $extra
     *
     * @return string
     */
    public function compile($stub, $modelName, $modelData, stdClass $scaffolderConfig, $hash, ScaffolderThemeExtensionInterface $themeExtension, array $extensions, $extra = null)
    {
        $this->stub = $stub;

        return $this->store(null, $scaffolderConfig, $themeExtension->runAfterEditLayoutIsCompiled($this->stub, $scaffolderConfig), new FileToCompile(null, null));
    }

    /**
     * Store the compiled stub.
     *
     * @param $modelName
     * @param \stdClass $scaffolderConfig
     * @param $compiled
     * @param \Scaffolder\Support\FileToCompile $fileToCompile
     *
     * @return string
     */
    protected function store($modelName, stdClass $scaffolderConfig, $compiled, FileToCompile $fileToCompile)
    {
        $path = PathParser::parse($scaffolderConfig->paths->views) . 'layouts/edit.blade.php';

        File::put($path, $compiled);

        return $path;
    }
}
