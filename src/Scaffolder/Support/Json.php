<?php

namespace Scaffolder\Support;

use Illuminate\Support\Facades\File;

class Json
{
    public static function decodeFile($path)
    {
        return json_decode(File::get($path));
    }
}