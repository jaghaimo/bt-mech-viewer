<?php

declare(strict_types=1);

namespace Btmv\Domain\Chassisdef;

use Btmv\Domain\EntityException;

final class ChassisdefException extends EntityException
{
    /**
     * @param string $hardpoint
     *
     * @return ChassisdefException
     */
    public static function invalidChassisdefHardpoint(string $hardpoint): ChassisdefException
    {
        return new self("Invalid chassisdef hardpoint: {$hardpoint}");
    }

    /**
     * @param string $location
     *
     * @return ChassisdefException
     */
    public static function invalidChassisdefLocation(string $location): ChassisdefException
    {
        return new self("Invalid chassisdef location: {$location}");
    }

    /**
     * @param \Throwable $throwable
     *
     * @return ChassisdefException
     */
    public static function missingProperty(\Throwable $throwable): ChassisdefException
    {
        $property = self::getPropertyName($throwable);

        return new self("Missing chassisdef property: {$property}");
    }
}
