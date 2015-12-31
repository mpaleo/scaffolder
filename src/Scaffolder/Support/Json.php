<?php

namespace Scaffolder\Support;

use Illuminate\Support\Facades\File;

class Json
{
    /**
     * json_decode wrapper.
     *
     * @param $path
     *
     * @return mixed
     */
    public static function decodeFile($path)
    {
        return json_decode(File::get($path));
    }
}
