<?php

use Orchestra\Testbench\TestCase;

class PackageTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            'Scaffolder\ScaffolderServiceProvider',
            'Collective\Html\HtmlServiceProvider'
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Form' => 'Collective\Html\FormFacade',
            'Html' => 'Collective\Html\HtmlFacade'
        ];
    }
}