<?php

namespace Scaffolder\Compilers;

abstract class AbstractViewCompiler extends AbstractCompiler
{
    /**
     * Replace the breadcrumb.
     *
     * @param $modelName
     * @param $modelLabel
     *
     * @return $this
     */
    protected function replaceBreadcrumb($modelName, $modelLabel)
    {
        $this->stub = str_replace('{{breadcrumb}}', ucfirst(strtolower($modelLabel)), $this->stub);
        $this->stub = str_replace('{{breadcrumb_lw}}', strtolower($modelName), $this->stub);

        return $this;
    }
}
