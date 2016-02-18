<?php

namespace Scaffolder\Compilers\Core\Api;

use Illuminate\Support\Facades\File;
use Scaffolder\Compilers\Core\ControllerCompiler;
use Scaffolder\Support\FileToCompile;
use stdClass;

class ApiControllerCompiler extends ControllerCompiler
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
        if (File::exists(base_path('scaffolder-config/cache/api_controller_' . $hash . self::CACHE_EXT)))
        {
            return $this->store($modelName, $scaffolderConfig, '', new FileToCompile(true, $hash));
        }
        else
        {
            $this->stub = $stub;

            $this->replaceClassName($modelName)
                ->setValidations($modelData);

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
        $path = base_path('../' . strtolower(str_replace(' ', '-', $scaffolderConfig->name . '-api'))) . '/app/Http/Controllers/' . $modelName . 'Controller.php';

        // Store in cache
        if ($fileToCompile->cached)
        {
            File::copy(base_path('scaffolder-config/cache/api_controller_' . $fileToCompile->hash . self::CACHE_EXT), $path);
        }
        else
        {
            File::put(base_path('scaffolder-config/cache/api_controller_' . $fileToCompile->hash . self::CACHE_EXT), $compiled);
            File::copy(base_path('scaffolder-config/cache/api_controller_' . $fileToCompile->hash . self::CACHE_EXT), $path);
        }

        return $path;
    }
}
