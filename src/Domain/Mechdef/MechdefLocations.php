<?php

declare(strict_types=1);

namespace Btmv\Domain\Mechdef;

final class MechdefLocations
{
    /**
     * @var MechdefPart[]
     */
    private $locations = [];

    public function __construct(array $locations)
    {
        foreach ($locations as $location) {
            $part = new MechdefPart($location);
            $key = $part->getLocation();
            $this->locations[$key] = $part;
        }
    }
}
