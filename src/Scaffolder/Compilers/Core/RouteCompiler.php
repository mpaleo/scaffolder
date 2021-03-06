<?php

namespace Scaffolder\Compilers\Core;

use Illuminate\Support\Facades\File;
use Scaffolder\Compilers\AbstractCoreCompiler;
use Scaffolder\Support\FileToCompile;
use Scaffolder\Support\PathParser;
use stdClass;

class RouteCompiler extends AbstractCoreCompiler
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
            ->replacePrefix($scaffolderConfig->routing->prefix)
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
        File::append(PathParser::parse($scaffolderConfig->paths->routes), PHP_EOL . $compiled);
    }

    /**
     * Replace the resource.
     *
     * @param $modelName
     *
     * @return $this
     */
    protected function replaceResource($modelName)
    {
        $this->stub = str_replace('{{resource_lw}}', strtolower($modelName), $this->stub);
        $this->stub = str_replace('{{resource}}', $modelName, $this->stub);

        return $this;
    }

    /**
     * Replace compiled routes.
     *
     * @param $compiledRoutes
     *
     * @return $this
     */
    protected function replaceRoutes($compiledRoutes)
    {
        $this->stub = str_replace('{{routes}}', $compiledRoutes, $this->stub);

        return $this;
    }

    /**
     * Replace the prefix.
     *
     * @param $prefix
     *
     * @return $this
     */
    private function replacePrefix($prefix)
    {
        $this->stub = str_replace('{{route_prefix}}', $prefix, $this->stub);

        return $this;
    }
}
