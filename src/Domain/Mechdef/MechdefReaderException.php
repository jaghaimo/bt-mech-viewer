<?php

declare(strict_types=1);

namespace Btmv\Domain\Mechdef;

final class MechdefReaderException extends \Exception
{
    public static function brokenMechdef(string $filename, \Throwable $throwable): MechdefReaderException
    {
        return new self("Invalid mechdef file: {$filename}", 0, $throwable);
    }
}
