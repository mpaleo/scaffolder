<?php

namespace Scaffolder\Themes;

interface IScaffolderThemeViews
{
    public function getCreatePath();

    public function getDashboardPath();

    public function getEditPath();

    public function getIndexPath();

    public function getWelcomePath();
}