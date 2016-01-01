<?php

namespace Scaffolder\Compilers;

use Scaffolder\Compilers\Support\FileToCompile;

abstract class AbstractCompiler
{
    protected $stub;

    const CACHE_EXT = '.scf';

    /**
     * Abstract compiler.
     *
     * @param $stub
     * @param $modelName
     * @param $modelData
     * @param \stdClass $scaffolderConfig
     * @param $hash
     * @param null $extra
     *
     * @return mixed
     */
    abstract public function compile($stub, $modelName, $modelData, \stdClass $scaffolderConfig, $hash, $extra = null);

    /**
     * Store the compiled stub.
     *
     * @param $modelName
     * @param \stdClass $scaffolderConfig
     * @param $compiled
     * @param \Scaffolder\Compilers\Support\FileToCompile $fileToCompile
     *
     * @return mixed
     */
    abstract protected function store($modelName, \stdClass $scaffolderConfig, $compiled, FileToCompile $fileToCompile);

    /**
     * Replace the class name.
     *
     * @param $modelName
     *
     * @return $this
     */
    protected function replaceClassName($modelName)
    {
        $this->stub = str_replace('{{class_name}}', $modelName, $this->stub);
        $this->stub = str_replace('{{class_name_lw}}', strtolower($modelName), $this->stub);

        return $this;
    }

    /**
     * Replace the namespace.
     *
     * @param \stdClass $scaffolderConfig
     *
     * @return $this
     */
    protected function replaceNamespace(\stdClass $scaffolderConfig)
    {
        $this->stub = str_replace('{{namespace}}', $scaffolderConfig->namespaces->models, $this->stub);

        return $this;
    }
}
