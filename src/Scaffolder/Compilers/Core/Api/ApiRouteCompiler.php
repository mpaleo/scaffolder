<?php

namespace Scaffolder\Compilers\Core\Api;

use Illuminate\Support\Facades\File;
use Scaffolder\Compilers\Core\RouteCompiler;
use Scaffolder\Support\FileToCompile;
use stdClass;

class ApiRouteCompiler extends RouteCompiler
{
    /**
     * Compiles a route.
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
        $this->stub = $stub;

        $this->replaceResource($modelName);

        return $this->stub;
    }

    /**
     * Compiles a group of routes.
     *
     * @param $stub
     * @param $compiledRoutes
     * @param \stdClass $scaffolderConfig
     *
     * @return string
     */
    public function compileGroup($stub, $compiledRoutes, stdClass $scaffolderConfig)
    {
        $this->stub = $stub;

        $this->replaceRoutes($compiledRoutes)
            ->store(null, $scaffolderConfig, $this->stub, new FileToCompile(null, null));

        return $this->stub;
    }

    /**
     * Store the compiled stub.
     *
     * @param $modelName
     * @param \stdClass $scaffolderConfig
     * @param $compiled
     * @param \Scaffolder\Support\FileToCompile $fileToCompile
     *
     * @return mixed|void
     */
    protected function store($modelName, stdClass $scaffolderConfig, $compiled, FileToCompile $fileToCompile)
    {
        File::append(base_path('../' . strtolower(str_replace(' ', '-', $scaffolderConfig->name . '-api'))) . '/app/Http/routes.php', PHP_EOL . $compiled);
    }
}
