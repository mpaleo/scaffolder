<?php

namespace Scaffolder\Compilers;

abstract class AbstractViewCompiler extends AbstractCompiler
{
    /**
     * Replace the breadcrumb.
     *
     * @param $modelName
     *
     * @return $this
     */
    protected function replaceBreadcrumb($modelName)
    {
        $this->stub = str_replace('{{breadcrumb}}', ucfirst($modelName), $this->stub);
        $this->stub = str_replace('{{breadcrumb_lw}}', strtolower($modelName), $this->stub);

        return $this;
    }
}