<?php

namespace Scaffolder\Support;

use Illuminate\Support\Facades\File;

class Directory
{
    public static function createIfNotExists($path)
    {
        if (!File::isDirectory($path))
        {
            File::makeDirectory($path);
        }
    }
}