<?php

namespace Scaffolder\Themes;

use Collective\Html\HtmlServiceProvider;

abstract class AbstractThemeServiceProvider extends HtmlServiceProvider
{
    public function register()
    {
        $this->registerHtmlBuilder();
        $this->registerThemeFormBuilder();
        $this->registerThemeViews();
        $this->registerThemeLayouts();
    }

    abstract protected function registerThemeFormBuilder();

    abstract protected function registerThemeViews();

    abstract protected function registerThemeLayouts();

    public function provides()
    {
        return ['html', 'form', 'scaffolder.theme.views', 'scaffolder.theme.layouts'];
    }
}