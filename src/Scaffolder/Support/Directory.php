<?php

namespace Scaffolder\Support;

use Illuminate\Support\Facades\File;

class Directory
{
    /**
     * Creates a directory if not exists.
     *
     * @param $path
     */
    public static function createIfNotExists($path)
    {
        if (!File::isDirectory($path))
        {
            File::makeDirectory($path);
        }
    }
}