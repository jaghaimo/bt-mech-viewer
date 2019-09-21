<?php

namespace Btmv\Domain\Mech;

class MechFactoryException extends \Exception
{
    /**
     * @param string $filename
     * @param \Throwable $throwable
     *
     * @return MechFactoryException
     */
    public static function brokenMechdef(string $filename, \Throwable $throwable): MechFactoryException
    {
        return new self("Invalid mechdef file: $filename", 0, $throwable);
    }
}
