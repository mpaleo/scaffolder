<?php

namespace Scaffolder\Themes;

interface IScaffolderThemeViews
{
    /**
     * Get the 'create view' path.
     * @return string
     */
    public function getCreatePath();

    /**
     * Get the 'dashboard view' path.
     * @return string
     */
    public function getDashboardPath();

    /**
     * Get the 'edit view' path.
     * @return string
     */
    public function getEditPath();

    /**
     * Get the 'index view' path.
     * @return string
     */
    public function getIndexPath();

    /**
     * Get the 'welcome view' path.
     * @return string
     */
    public function getWelcomePath();
}