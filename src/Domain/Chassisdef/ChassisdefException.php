<?php

declare(strict_types=1);

namespace Btmv\Domain\Chassisdef;

use Btmv\Domain\EntityException;

final class ChassisdefException extends EntityException
{
    public static function invalidChassisdefHardpoint(string $hardpoint): ChassisdefException
    {
        return new self("Invalid chassisdef hardpoint: {$hardpoint}");
    }

    public static function invalidChassisdefLocation(string $location): ChassisdefException
    {
        return new self("Invalid chassisdef location: {$location}");
    }

    public static function missingProperty(\Throwable $throwable): ChassisdefException
    {
        $property = self::getPropertyName($throwable);

        return new self("Missing chassisdef property: {$property}");
    }
}
