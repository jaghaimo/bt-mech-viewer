<?php

namespace Btmv\Domain\Mech;

use Btmv\Domain\EntityException;

class MechException extends EntityException
{
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
