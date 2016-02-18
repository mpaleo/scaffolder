<?php

namespace Scaffolder\Compilers\Core;

use Illuminate\Support\Facades\File;
use Scaffolder\Compilers\AbstractCoreCompiler;
use Scaffolder\Support\FileToCompile;
use Scaffolder\Support\PathParser;
use stdClass;

class ControllerCompiler extends AbstractCoreCompiler
{
    /**
     * Compiles a controller.
     *
     * @param $stub
     * @param $modelName
     * @param $modelData
     * @param \stdClass $scaffolderConfig
     * @param $hash
     * @param \Scaffolder\Support\Contracts\ScaffolderExtensionInterface[] $extensions
     * @param null $extra
     *
     * @return string
     */
    public function compile($stub, $modelName, $modelData, stdClass $scaffolderConfig, $hash, array $extensions, $extra = null)
    {
        if (File::exists(base_path('scaffolder-config/cache/controller_' . $hash . self::CACHE_EXT)))
        {
            return $this->store($modelName, $scaffolderConfig, '', new FileToCompile(true, $hash));
        }
        else
        {
            $this->stub = $stub;

            $this->replaceClassName($modelName)
                ->setValidations($modelData)
                ->replacePrimaryKey($modelData)
                ->replaceRoutePrefix($scaffolderConfig->routing->prefix);

            foreach ($extensions as $extension)
            {
                $this->stub = $extension->runAfterControllerIsCompiled($this->stub, $modelData, $scaffolderConfig);
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
    protected function setValidations($modelData)
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
                $fields .= sprintf($this->tab(3) . "'%s' => '%s'," . PHP_EOL, $field->name, $field->validations);
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
