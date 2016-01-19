<?php

namespace Scaffolder\Compilers;

use Scaffolder\Support\Contracts\ScaffolderThemeExtensionInterface;
use stdClass;

abstract class AbstractViewCompiler extends AbstractCompiler
{
    /**
     * Abstract compiler.
     *
     * @param $stub
     * @param $modelName
     * @param $modelData
     * @param \stdClass $scaffolderConfig
     * @param $hash
     * @param \Scaffolder\Support\Contracts\ScaffolderThemeExtensionInterface $themeExtension
     * @param \Scaffolder\Support\Contracts\ScaffolderExtensionInterface[] $extensions
     * @param null $extra
     *
     * @return mixed
     */
    abstract public function compile($stub, $modelName, $modelData, stdClass $scaffolderConfig, $hash, ScaffolderThemeExtensionInterface $themeExtension, array $extensions, $extra = null);

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
