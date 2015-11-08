<?php

namespace Scaffolder\Compilers\Support;

class PathParser
{
    /**
     * Parse a path.
     *
     * @param $path
     */
    public static function parse($path)
    {
        $path = explode(':', $path, 2);

        if (count($path) == 2)
        {
            if (head($path) == 'app')
            {
                $path = app_path(last($path));
            }
            elseif (head($path) == 'base')
            {
                $path = base_path(last($path));
            }
            elseif (head($path) == 'config')
            {
                $path = config_path(last($path));
            }
            elseif (head($path) == 'database')
            {
                $path = database_path(last($path));
            }
            elseif (head($path) == 'public')
            {
                $path = public_path(last($path));
            }
            elseif (head($path) == 'storage')
            {
                $path = storage_path(last($path));
            }
            else
            {
                $path = head($path);
            }
        }
        else
        {
            $path = head($path);
        }

        return $path;
    }
}