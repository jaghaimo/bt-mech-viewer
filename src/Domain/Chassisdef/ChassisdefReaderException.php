<?php

declare(strict_types=1);

namespace Btmv\Domain\Chassisdef;

final class ChassisdefReaderException extends \Exception
{
    public static function brokenChassisdef(string $filename, \Throwable $throwable): ChassisdefReaderException
    {
        return new self("Invalid chassisdef file: {$filename}", 0, $throwable);
    }
}
