<?php

namespace Scaffolder\Compilers;

use Scaffolder\Support\FileToCompile;
use stdClass;

abstract class AbstractCompiler
{
    /**
     * File stub.
     * @var string
     */
    protected $stub;


    /**
     * Cache file extension.
     */
    const CACHE_EXT = '.scf';

    /**
     * Store the compiled stub.
     *
     * @param $modelName
     * @param \stdClass $scaffolderConfig
     * @param $compiled
     * @param \Scaffolder\Support\FileToCompile $fileToCompile
     *
     * @return mixed
     */
    abstract protected function store($modelName, stdClass $scaffolderConfig, $compiled, FileToCompile $fileToCompile);

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
    protected function replaceNamespace(stdClass $scaffolderConfig)
    {
        $this->stub = str_replace('{{namespace}}', $scaffolderConfig->namespaces->models, $this->stub);

        return $this;
    }

    /**
     * Tab helper.
     *
     * @param $size
     *
     * @return string
     */
    protected function tab($size)
    {
        return str_repeat('    ', $size);
    }
}
