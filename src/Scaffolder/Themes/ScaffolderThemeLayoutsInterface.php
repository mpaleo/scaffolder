<?php

namespace Scaffolder\Themes;

interface ScaffolderThemeLayoutsInterface
{
    /**
     * Get the create layout path.
     * @return string
     */
    public function getCreatePath();

    /**
     * Get the edit layout path.
     * @return string
     */
    public function getEditPath();

    /**
     * Get the page layout path.
     * @return string
     */
    public function getPagePath();
}
