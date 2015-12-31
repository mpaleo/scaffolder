<?php

namespace Scaffolder\Compilers\Core;

use Illuminate\Support\Facades\File;
use Scaffolder\Compilers\AbstractCompiler;
use Scaffolder\Compilers\Support\FileToCompile;
use Scaffolder\Compilers\Support\PathParser;

class RouteCompiler extends AbstractCompiler
{
    /**
     * Compiles a route.
     *
     * @param $stub
     * @param $modelName
     * @param $modelData
     * @param $scaffolderConfig
     * @param $hash
     * @param null $extra
     *
     * @return mixed
     */
    public function compile($stub, $modelName, $modelData, $scaffolderConfig, $hash, $extra = null)
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
     * @param $scaffolderConfig
     *
     * @return mixed
     */
    public function compileGroup($stub, $compiledRoutes, $scaffolderConfig)
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
     * @param $scaffolderConfig
     * @param $compiled
     * @param \Scaffolder\Compilers\Support\FileToCompile $fileToCompile
     *
     * @return mixed|void
     */
    protected function store($modelName, $scaffolderConfig, $compiled, FileToCompile $fileToCompile)
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
    private function replaceResource($modelName)
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
    private function replaceRoutes($compiledRoutes)
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