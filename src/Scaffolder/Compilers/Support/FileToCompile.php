<?php

namespace Scaffolder\Compilers\Support;

class FileToCompile
{
    public $cached;
    public $hash;

    public function __construct($cached, $hash)
    {
        $this->cached = $cached;
        $this->hash = $hash;
    }
}