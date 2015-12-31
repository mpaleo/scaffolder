<?php

namespace Scaffolder\Compilers\Core;

use Illuminate\Support\Facades\File;
use Scaffolder\Compilers\AbstractCompiler;
use Scaffolder\Compilers\Support\FileToCompile;
use Scaffolder\Compilers\Support\PathParser;

class ControllerCompiler extends AbstractCompiler
{
    /**
     * Compiles a controller.
     *
     * @param $stub
     * @param $modelName
     * @param $modelData
     * @param $scaffolderConfig
     * @param $hash
     * @param null $extra
     *
     * @return string
     */
    public function compile($stub, $modelName, $modelData, $scaffolderConfig, $hash, $extra = null)
    {
        if (File::exists(base_path('scaffolder-config/cache/controller_' . $hash . self::CACHE_EXT)))
        {
            return $this->store($modelName, $scaffolderConfig, '', new FileToCompile(true, $hash));
        }
        else
        {
            $this->stub = $stub;

            return $this->replaceClassName($modelName)
                ->setValidations($modelData)
                ->replacePrimaryKey($modelData)
                ->replaceRoutePrefix($scaffolderConfig->routing->prefix)
                ->store($modelName, $scaffolderConfig, $this->stub, new FileToCompile(false, $hash));
        }
    }

    /**
     * Store the compiled stub.
     *
     * @param $modelName
     * @param $scaffolderConfig
     * @param $compiled
     * @param \Scaffolder\Compilers\Support\FileToCompile $fileToCompile
     *
     * @return string
     */
    protected function store($modelName, $scaffolderConfig, $compiled, FileToCompile $fileToCompile)
    {
        $path = PathParser::parse($scaffolderConfig->paths->controllers) . $modelName . 'Controller.php';

        // Store in cache
        if ($fileToCompile->cached)
        {
            File::copy(base_path('scaffolder-config/cache/controller_' . $fileToCompile->hash . self::CACHE_EXT), $path);
        }
        else
        {
            File::put(base_path('scaffolder-config/cache/controller_' . $fileToCompile->hash . self::CACHE_EXT), $compiled);
            File::copy(base_path('scaffolder-config/cache/controller_' . $fileToCompile->hash . self::CACHE_EXT), $path);
        }

        return $path;
    }

    /**
     * Set validations.
     *
     * @param $modelData
     *
     * @return $this
     */
    private function setValidations($modelData)
    {
        $fields = '';
        $firstIteration = true;

        foreach ($modelData->fields as $field)
        {
            if ($firstIteration)
            {
                $fields .= sprintf("'%s' => '%s'," . PHP_EOL, $field->name, $field->validations);
                $firstIteration = false;
            }
            else
            {
                $fields .= sprintf("\t\t\t'%s' => '%s'," . PHP_EOL, $field->name, $field->validations);
            }
        }

        $this->stub = str_replace('{{validations}}', $fields, $this->stub);

        return $this;
    }

    /**
     * Replace the route prefix.
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