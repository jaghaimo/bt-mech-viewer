<?php

namespace Btmv\Domain\Chassisdef;

class ChassisdefFactoryException extends \Exception
{
    /**
     * @param string     $filename
     * @param \Throwable $throwable
     *
     * @return ChassisdefFactoryException
     */
    public static function brokenChassisdef(string $filename, \Throwable $throwable): ChassisdefFactoryException
    {
        return new self("Invalid chassisdef file: {$filename}", 0, $throwable);
    }
}
