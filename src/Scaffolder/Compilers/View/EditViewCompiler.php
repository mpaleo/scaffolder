<?php

namespace Scaffolder\Compilers\View;

use Illuminate\Support\Facades\File;
use Scaffolder\Compilers\AbstractViewCompiler;
use Scaffolder\Compilers\Support\FileToCompile;
use Scaffolder\Compilers\Support\InputTypeResolverTrait;
use Scaffolder\Compilers\Support\PathParser;

class EditViewCompiler extends AbstractViewCompiler
{
    use InputTypeResolverTrait;

    /**
     * Compiles the edit view.
     *
     * @param      $stub
     * @param      $modelName
     * @param      $modelData
     * @param      $scaffolderConfig
     * @param      $hash
     * @param null $extra
     *
     * @return string
     */
    public function compile($stub, $modelName, $modelData, $scaffolderConfig, $hash, $extra = null)
    {
        if (File::exists(base_path('scaffolder-config/cache/view_edit_' . $hash . self::CACHE_EXT)))
        {
            return $this->store($modelName, $scaffolderConfig, '', new FileToCompile(true, $hash));
        }
        else
        {
            $this->stub = $stub;

            return $this->replaceClassName($modelName)
                ->replaceBreadcrumb($modelName)
                ->addFields($modelData)
                ->replacePrimaryKey($modelData)
                ->replaceRoutePrefix($scaffolderConfig->routing->prefix)
                ->store($modelName, $scaffolderConfig, $this->stub, new FileToCompile(false, $hash));
        }
    }

    /**
     * Store the compiled stub.
     *
     * @param               $modelName
     * @param               $scaffolderConfig
     * @param               $compiled
     * @param FileToCompile $fileToCompile
     *
     * @return string
     */
    protected function store($modelName, $scaffolderConfig, $compiled, FileToCompile $fileToCompile)
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