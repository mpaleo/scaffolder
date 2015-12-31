<?php

namespace Scaffolder\Themes;

use Collective\Html\HtmlServiceProvider;

abstract class AbstractThemeServiceProvider extends HtmlServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerHtmlBuilder();
        $this->registerThemeFormBuilder();
        $this->registerThemeViews();
        $this->registerThemeLayouts();
    }

    /**
     * Register the form builder instance.
     */
    abstract protected function registerThemeFormBuilder();

    /**
     * Register the theme views instance.
     */
    abstract protected function registerThemeViews();

    /**
     * Register the theme layouts instance.
     */
    abstract protected function registerThemeLayouts();

    /**
     * Get the services provided by the provider.
     * @return array
     */
    public function provides()
    {
        return ['html', 'form', 'scaffolder.theme.views', 'scaffolder.theme.layouts'];
    }
}