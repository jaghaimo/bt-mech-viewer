<?php

namespace Btmv\Domain\Mech;

use Btmv\Domain\EntityException;

class MechException extends EntityException
{
    /**
     * @param string $hardpoint
     *
     * @return MechException
     */
    public static function invalidMechHardpoint(string $hardpoint): MechException
    {
        return new self("Invalid mech hardpoint: $hardpoint");
    }

    /**
     * @param string $location
     *
     * @return MechException
     */
    public static function invalidMechLocation(string $location): MechException
    {
        return new self("Invalid mech location: $location");
    }

    /**
     * @param \Throwable $throwable
     *
     * @return MechException
     */
    public static function missingProperty(\Throwable $throwable): MechException
    {
        $property = self::getPropertyName($throwable);

        return new self("Missing mech object property: $property");
    }
}
