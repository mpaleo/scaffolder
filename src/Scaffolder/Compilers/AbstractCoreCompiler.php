<?php

namespace Scaffolder\Compilers;

use stdClass;

abstract class AbstractCoreCompiler extends AbstractCompiler
{
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
    abstract public function compile($stub, $modelName, $modelData, stdClass $scaffolderConfig, $hash, $extra = null);
}
