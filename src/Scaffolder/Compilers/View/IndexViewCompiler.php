<?php

namespace Scaffolder\Compilers\View;

use Illuminate\Support\Facades\File;
use Scaffolder\Compilers\AbstractViewCompiler;
use Scaffolder\Compilers\Support\FileToCompile;
use Scaffolder\Compilers\Support\PathParser;

class IndexViewCompiler extends AbstractViewCompiler
{
    /**
     * Compiles the index view.
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
        if (File::exists(base_path('scaffolder-config/cache/view_index_' . $hash . self::CACHE_EXT)))
        {
            return $this->store($modelName, $scaffolderConfig, '', new FileToCompile(true, $hash));
        }
        else
        {
            $this->stub = $stub;

            return $this->replaceClassName($modelName)
                ->replaceBreadcrumb($modelName, $modelData->modelLabel)
                ->addDatatableFields($modelName, $modelData)
                ->setTableHeaders($modelData)
                ->replaceRoutePrefix($scaffolderConfig->routing->prefix)
                ->store($modelName, $scaffolderConfig, $this->stub, new FileToCompile(false, $hash));
        }
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
        $path = PathParser::parse($scaffolderConfig->paths->views) . strtolower($modelName) . '/index.blade.php';

        // Store in cache
        if ($fileToCompile->cached)
        {
            File::copy(base_path('scaffolder-config/cache/view_index_' . $fileToCompile->hash . self::CACHE_EXT), $path);
        }
        else
        {
            File::put(base_path('scaffolder-config/cache/view_index_' . $fileToCompile->hash . self::CACHE_EXT), $compiled);
            File::copy(base_path('scaffolder-config/cache/view_index_' . $fileToCompile->hash . self::CACHE_EXT), $path);
        }

        return $path;
    }

    /**
     * Datatable fields.
     *
     * @param $modelName
     * @param $modelData
     *
     * @return $this
     */
    private function addDatatableFields($modelName, $modelData)
    {
        $fields = '';
        $firstIteration = true;

        foreach ($modelData->fields as $field)
        {
            if ($field->hideInListings == false)
            {
                if ($firstIteration)
                {
                    $fields .= sprintf("{ data: '%s', name: '%s' }," . PHP_EOL, $field->name, $field->name);
                    $firstIteration = false;
                }
                else
                {
                    $fields .= sprintf("\t\t\t\t{ data: '%s', name: '%s' }," . PHP_EOL, $field->name, $field->name);
                }
            }
        }

        $this->stub = str_replace('{{datatable_fields}}', $fields, $this->stub);
        $this->stub = str_replace('{{datatable_url}}', ucfirst($modelName), $this->stub);

        return $this;
    }

    /**
     * Set index table headers.
     *
     * @param $modelData
     *
     * @return $this
     */
    private function setTableHeaders($modelData)
    {
        $fields = '';
        $firstIteration = true;

        foreach ($modelData->fields as $field)
        {
            if ($field->hideInListings == false)
            {
                if ($firstIteration)
                {
                    $fields .= sprintf("<th>%s</th>" . PHP_EOL, ucfirst($field->name));
                    $firstIteration = false;

                }
                else
                {
                    $fields .= sprintf("\t\t\t<th>%s</th>" . PHP_EOL, ucfirst($field->name));
                }
            }
        }

        $this->stub = str_replace('{{table_headers}}', $fields, $this->stub);

        return $this;
    }

    /**
     * Replace the prefix.
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