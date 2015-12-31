<?php

namespace Scaffolder\Compilers\Support;

class FileToCompile
{
    /**
     * Indicates if file is cached.
     * @var bool
     */
    public $cached;

    /**
     * File hash
     * @var string
     */
    public $hash;

    /**
     * Create a new file to compile instance.
     *
     * @param $cached
     * @param $hash
     */
    public function __construct($cached, $hash)
    {
        $this->cached = $cached;
        $this->hash = $hash;
    }
}
