<?php

namespace Chebur\DBALSphinx\Driver;

class SphinxException extends \Exception
{
    /**
     * @param string $method
     *
     * @return static
     */
    public static function notSupported($method)
    {
        return new static("Operation '$method' is not supported by Sphinx.");
    }

}
