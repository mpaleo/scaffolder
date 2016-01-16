<?php

namespace Scaffolder\Compilers\View;

use Illuminate\Support\Facades\File;
use Scaffolder\Compilers\AbstractViewCompiler;
use Scaffolder\Compilers\Support\FileToCompile;
use Scaffolder\Compilers\Support\InputTypeResolverTrait;
use Scaffolder\Compilers\Support\PathParser;
use Scaffolder\Themes\ScaffolderThemeExtensionInterface;
use stdClass;

class CreateViewCompiler extends AbstractViewCompiler
{
    use InputTypeResolverTrait;

    /**
     * Compiles the create view.
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
        if (File::exists(base_path('scaffolder-config/cache/view_create_' . $hash . self::CACHE_EXT)))
        {
            return $this->store($modelName, $scaffolderConfig, '', new FileToCompile(true, $hash));
        }
        else
        {
            $this->stub = $stub;

            return $this->replaceClassName($modelName)
                ->replaceBreadcrumb($modelName, $modelData->modelLabel)
                ->addFields($modelData)
                ->replaceRoutePrefix($scaffolderConfig->routing->prefix)
                ->store($modelName, $scaffolderConfig, $themeExtension->runAfterCreateViewIsCompiled($this->stub, $modelData, $scaffolderConfig), new FileToCompile(false, $hash));
        }
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
        $path = PathParser::parse($scaffolderConfig->paths->views) . strtolower($modelName) . '/create.blade.php';

        // Store in cache
        if ($fileToCompile->cached)
        {
            File::copy(base_path('scaffolder-config/cache/view_create_' . $fileToCompile->hash . self::CACHE_EXT), $path);
        }
        else
        {
            File::put(base_path('scaffolder-config/cache/view_create_' . $fileToCompile->hash . self::CACHE_EXT), $compiled);
            File::copy(base_path('scaffolder-config/cache/view_create_' . $fileToCompile->hash . self::CACHE_EXT), $path);
        }

        return $path;
    }

    /**
     * Add fields to the create view.
     *
     * @param $modelData
     *
     * @return $this
     */
    private function addFields($modelData)
    {
        $fields = '';
        $firstIteration = true;

        foreach ($modelData->fields as $field)
        {
            if ($firstIteration)
            {
                $fields .= self::getInputFor($field) . PHP_EOL;
                $firstIteration = false;
            }
            else
            {
                $fields .= "\t" . self::getInputFor($field) . PHP_EOL;
            }
        }

        $this->stub = str_replace('{{fields}}', $fields, $this->stub);

        return $this;
    }

    /**
     * Replace the prefix.
     *
     * @param string $prefix
     *
     * @return $this
     */
    private function replaceRoutePrefix($prefix)
    {
        $this->stub = str_replace('{{route_prefix}}', $prefix, $this->stub);

        return $this;
    }
}
