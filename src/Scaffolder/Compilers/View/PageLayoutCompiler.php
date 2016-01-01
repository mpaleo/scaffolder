<?php

namespace Scaffolder\Compilers\View;

use Illuminate\Support\Facades\File;
use Scaffolder\Compilers\AbstractViewCompiler;
use Scaffolder\Compilers\Support\FileToCompile;
use Scaffolder\Compilers\Support\PathParser;

class PageLayoutCompiler extends AbstractViewCompiler
{
    /**
     * Compiles the page layout.
     *
     * @param $stub
     * @param $modelName
     * @param $modelData
     * @param \stdClass $scaffolderConfig
     * @param $hash
     * @param null $extra
     *
     * @return string
     */
    public function compile($stub, $modelName, $modelData, \stdClass $scaffolderConfig, $hash, $extra = null)
    {
        $this->stub = $stub;

        return $this->setPageTitle($scaffolderConfig)
            ->setAppName($scaffolderConfig)
            ->setLinks($extra['links'], $scaffolderConfig)
            ->replaceRoutePrefix($scaffolderConfig->routing->prefix)
            ->store($modelName, $scaffolderConfig, $this->stub, new FileToCompile(null, null));
    }

    /**
     * Store the compiled stub.
     *
     * @param $modelName
     * @param \stdClass $scaffolderConfig
     * @param $compiled
     * @param \Scaffolder\Compilers\Support\FileToCompile $fileToCompile
     *
     * @return string
     */
    protected function store($modelName, \stdClass $scaffolderConfig, $compiled, FileToCompile $fileToCompile)
    {
        $path = PathParser::parse($scaffolderConfig->paths->views) . 'layouts/page.blade.php';

        File::put($path, $compiled);

        return $path;
    }

    /**
     * Replace the page title.
     *
     * @param \stdClass $scaffolderConfig
     *
     * @return $this
     */
    private function setPageTitle(\stdClass $scaffolderConfig)
    {
        $this->stub = str_replace('{{page_title}}', $scaffolderConfig->userInterface->pageTitle, $this->stub);

        return $this;
    }

    /**
     * Replace the app name.
     *
     * @param \stdClass $scaffolderConfig
     *
     * @return $this
     */
    private function setAppName(\stdClass $scaffolderConfig)
    {
        $this->stub = str_replace('{{app_name}}', $scaffolderConfig->name, $this->stub);

        return $this;
    }

    /**
     * Add links to the nav.
     *
     * @param $links
     * @param \stdClass $scaffolderConfig
     *
     * @return $this
     */
    private function setLinks($links, \stdClass $scaffolderConfig)
    {
        $navLinks = '';

        foreach ($links as $link)
        {
            $navLinks .= sprintf("
            <li>
                <a href='/%s' class='waves-effect'>
                    %s
                </a>
            </li>", $scaffolderConfig->routing->prefix . '/' . strtolower($link['modelName']), $link['modelLabel']);
        }

        $this->stub = str_replace('{{links}}', $navLinks, $this->stub);

        return $this;
    }

    /**
     * Replace the route prefix.
     *
     * @param $prefix
     *
     * @return $this
     */
    private function replaceRoutePrefix($prefix)
    {
        $this->stub = str_replace('{{route_prefix}}', $prefix, $this->stub);

        return $this;
    }
}
