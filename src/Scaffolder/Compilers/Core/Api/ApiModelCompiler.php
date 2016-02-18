<?php

namespace Scaffolder\Compilers\Core\Api;

use Illuminate\Support\Facades\File;
use Scaffolder\Compilers\Core\ModelCompiler;
use Scaffolder\Support\FileToCompile;
use stdClass;

class ApiModelCompiler extends ModelCompiler
{
    /**
     * Compiles a model.
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
        if (File::exists(base_path('scaffolder-config/cache/api_model_' . $hash . self::CACHE_EXT)))
        {
            return $this->store($modelName, $scaffolderConfig, '', new FileToCompile(true, $hash));
        }
        else
        {
            $this->stub = $stub;

            $this->replaceClassName($modelName)
                ->setPrimaryKey($modelData)
                ->addFillable($modelData)
                ->replaceTableName($scaffolderConfig, $modelName);

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
        $path = base_path('../' . strtolower(str_replace(' ', '-', $scaffolderConfig->name . '-api'))) . '/app/Models/' . $modelName . '.php';

        // Store in cache
        if ($fileToCompile->cached)
        {
            File::copy(base_path('scaffolder-config/cache/api_model_' . $fileToCompile->hash . self::CACHE_EXT), $path);
        }
        else
        {
            File::put(base_path('scaffolder-config/cache/api_model_' . $fileToCompile->hash . self::CACHE_EXT), $compiled);
            File::copy(base_path('scaffolder-config/cache/api_model_' . $fileToCompile->hash . self::CACHE_EXT), $path);
        }

        return $path;
    }
}
