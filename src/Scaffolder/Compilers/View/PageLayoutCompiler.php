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
     * @param      $stub
     * @param      $modelName
     * @param      $modelData
     * @param      $scaffolderConfig
     * @param      $hash
     * @param null $extra
     *
     * @return string
     */
    public function compile($stub, $modelName, $modelData, $scaffolderConfig, $hash, $extra = null)
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
     * @param               $modelName
     * @param               $scaffolderConfig
     * @param               $compiled
     * @param FileToCompile $fileToCompile
     *
     * @return string
     */
    protected function store($modelName, $scaffolderConfig, $compiled, FileToCompile $fileToCompile)
    {
        $path = PathParser::parse($scaffolderConfig->paths->views) . 'layouts/page.blade.php';

        File::put($path, $compiled);

        return $path;
    }

    /**
     * Replace the page title.
     *
     * @param $scaffolderConfig
     *
     * @return $this
     */
    private function setPageTitle($scaffolderConfig)
    {
        $this->stub = str_replace('{{page_title}}', $scaffolderConfig->userInterface->pageTitle, $this->stub);

        return $this;
    }

    /**
     * Replace the app name.
     *
     * @param $scaffolderConfig
     *
     * @return $this
     */
    private function setAppName($scaffolderConfig)
    {
        $this->stub = str_replace('{{app_name}}', $scaffolderConfig->name, $this->stub);

        return $this;
    }

    /**
     * Add links to the nav.
     *
     * @param $links
     * @param $scaffolderConfig
     *
     * @return $this
     */
    private function setLinks($links, $scaffolderConfig)
    {
        $navLinks = '';

        foreach ($links as $link)
        {
            $navLinks .= sprintf("
            <li>
                <a href='/%s' class='waves-effect'>
                    %ss
                </a>
            </li>", $scaffolderConfig->routing->prefix . '/' . strtolower($link), $link);
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