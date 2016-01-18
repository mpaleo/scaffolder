<?php

namespace Scaffolder\Compilers\Core;

use Illuminate\Support\Facades\File;
use Scaffolder\Compilers\AbstractCoreCompiler;
use Scaffolder\Compilers\Support\FileToCompile;
use Scaffolder\Compilers\Support\PathParser;
use stdClass;

class ModelCompiler extends AbstractCoreCompiler
{
    /**
     * Compiles a model.
     *
     * @param $stub
     * @param $modelName
     * @param $modelData
     * @param \stdClass $scaffolderConfig
     * @param $hash
     * @param null $extra
     *
     * @return string
     */
    public function compile($stub, $modelName, $modelData, stdClass $scaffolderConfig, $hash, $extra = null)
    {
        if (File::exists(base_path('scaffolder-config/cache/model_' . $hash . self::CACHE_EXT)))
        {
            return $this->store($modelName, $scaffolderConfig, '', new FileToCompile(true, $hash));
        }
        else
        {
            $this->stub = $stub;

            return $this->replaceNamespace($scaffolderConfig)
                ->replaceNamespaceModelExtend($scaffolderConfig)
                ->replaceClassName($modelName)
                ->setPrimaryKey($modelData)
                ->addFillable($modelData)
                ->replaceTableName($scaffolderConfig, $modelName)
                ->store($modelName, $scaffolderConfig, $this->stub, new FileToCompile(false, $hash));
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
        $path = PathParser::parse($scaffolderConfig->paths->models) . $modelName . '.php';

        // Store in cache
        if ($fileToCompile->cached)
        {
            File::copy(base_path('scaffolder-config/cache/model_' . $fileToCompile->hash . self::CACHE_EXT), $path);
        }
        else
        {
            File::put(base_path('scaffolder-config/cache/model_' . $fileToCompile->hash . self::CACHE_EXT), $compiled);
            File::copy(base_path('scaffolder-config/cache/model_' . $fileToCompile->hash . self::CACHE_EXT), $path);
        }

        return $path;
    }

    /**
     * Replace the namespace which the model extends
     *
     * @param \stdClass $scaffolderConfig
     *
     * @return $this
     */
    private function replaceNamespaceModelExtend(stdClass $scaffolderConfig)
    {
        $this->stub = str_replace('{{namespace_model_extend}}', $scaffolderConfig->inheritance->model, $this->stub);

        return $this;
    }

    /**
     * Add fillable.
     *
     * @param $modelData
     *
     * @return $this
     */
    private function addFillable($modelData)
    {
        $fields = '';
        $firstIteration = true;

        foreach ($modelData->fields as $field)
        {
            if ($firstIteration)
            {
                $fields .= sprintf("'%s'," . PHP_EOL, $field->name);
                $firstIteration = false;
            }
            else
            {
                $fields .= sprintf("\t\t'%s'," . PHP_EOL, $field->name);
            }
        }

        $this->stub = str_replace('{{fillable}}', $fields, $this->stub);

        return $this;
    }

    /**
     * Replace the table name.
     *
     * @param \stdClass $scaffolderConfig
     * @param $modelName
     *
     * @return $this
     */
    private function replaceTableName(stdClass $scaffolderConfig, $modelName)
    {
        $tableName = isset($scaffolderConfig->tableName) && !empty($scaffolderConfig->tableName) ? $scaffolderConfig->tableName : $modelName . 's';

        $this->stub = str_replace('{{table_name}}', strtolower($tableName), $this->stub);

        return $this;
    }

    /**
     * Set the primary key.
     *
     * @param $modelData
     *
     * @return $this
     */
    private function setPrimaryKey($modelData)
    {
        $primaryKey = '// Using default primary key' . PHP_EOL;

        foreach ($modelData->fields as $field)
        {
            if ($field->index == 'primary')
            {
                $primaryKey = 'protected $primaryKey = \'' . $field->name . '\';' . PHP_EOL;
                break;
            }
        }

        $this->stub = str_replace('{{primaryKey}}', $primaryKey, $this->stub);

        return $this;
    }
}
