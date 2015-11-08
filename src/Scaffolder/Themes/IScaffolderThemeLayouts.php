<?php

namespace Scaffolder\Themes;

interface IScaffolderThemeLayouts
{
    public function getCreatePath();

    public function getEditPath();

    public function getPagePath();
}