<?php

namespace Scaffolder\Compilers\View;

use Illuminate\Support\Facades\File;
use Scaffolder\Compilers\AbstractViewCompiler;
use Scaffolder\Support\Contracts\ScaffolderThemeExtensionInterface;
use Scaffolder\Support\FileToCompile;
use Scaffolder\Support\InputTypeResolverTrait;
use Scaffolder\Support\PathParser;
use stdClass;

class EditViewCompiler extends AbstractViewCompiler
{
    use InputTypeResolverTrait;

    /**
     * Compiles the edit view.
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
        if (File::exists(base_path('scaffolder-config/cache/view_edit_' . $hash . self::CACHE_EXT)))
        {
            return $this->store($modelName, $scaffolderConfig, '', new FileToCompile(true, $hash));
        }
        else
        {
            $this->stub = $stub;

            $this->replaceClassName($modelName)
                ->replaceBreadcrumb($modelName, $modelData->modelLabel)
                ->addFields($modelData)
                ->replacePrimaryKey($modelData)
                ->replaceRoutePrefix($scaffolderConfig->routing->prefix);

            $this->stub = $themeExtension->runAfterEditViewIsCompiler($this->stub, $modelData, $scaffolderConfig);

            foreach ($extensions as $extension)
            {
                $this->stub = $extension->runAfterEditViewIsCompiler($this->stub, $modelData, $scaffolderConfig);
            }

            return $this->store($modelName, $scaffolderConfig, $this->stub, new FileToCompile(false, $hash));
        }
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
        $path = PathParser::parse($scaffolderConfig->paths->views) . strtolower($modelName) . '/edit.blade.php';

        // Store in cache
        if ($fileToCompile->cached)
        {
            File::copy(base_path('scaffolder-config/cache/view_edit_' . $fileToCompile->hash . self::CACHE_EXT), $path);
        }
        else
        {
            File::put(base_path('scaffolder-config/cache/view_edit_' . $fileToCompile->hash . self::CACHE_EXT), $compiled);
            File::copy(base_path('scaffolder-config/cache/view_edit_' . $fileToCompile->hash . self::CACHE_EXT), $path);
        }

        return $path;
    }

    /**
     * Add fields to the edit view.
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
     * @param $prefix
     *
     * @return $this
     */
    private function replaceRoutePrefix($prefix)
    {
        $this->stub = str_replace('{{route_prefix}}', $prefix, $this->stub);

        return $this;
    }

    /**
     * Replace the primary key.
     *
     * @param $modelData
     *
     * @return $this
     */
    private function replacePrimaryKey($modelData)
    {
        $primaryKey = 'id';

        foreach ($modelData->fields as $field)
        {
            if ($field->index == 'primary')
            {
                $primaryKey = $field->name;
                break;
            }
        }

        $this->stub = str_replace('{{primaryKey}}', $primaryKey, $this->stub);

        return $this;
    }
}
