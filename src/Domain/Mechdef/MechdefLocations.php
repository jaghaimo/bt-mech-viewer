<?php

declare(strict_types=1);

namespace Btmv\Domain\Mechdef;

use Btmv\Domain\Mech\MechEntity;

final class MechdefLocations
{
    /** @var MechdefPart[] */
    private array $parts = [];

    public function __construct(array $locations, array $inventory)
    {
        foreach ($locations as $location) {
            $part = new MechdefPart($location);
            $key = $part->getLocation();
            $this->parts[$key] = $part;
        }

        foreach ($inventory as $item) {
            $mechdefItem = new MechdefItem($item);
            $location = $mechdefItem->getLocation();
            $this->parts[$location]->addItem($mechdefItem);
        }
    }

    public function getCenterTorso(): MechdefPart
    {
        return $this->parts[MechEntity::LOCATION_CENTER_TORSO];
    }

    public function getHead(): MechdefPart
    {
        return $this->parts[MechEntity::LOCATION_HEAD];
    }

    public function getLeftArm(): MechdefPart
    {
        return $this->parts[MechEntity::LOCATION_LEFT_ARM];
    }

    public function getLeftLeg(): MechdefPart
    {
        return $this->parts[MechEntity::LOCATION_LEFT_LEG];
    }

    public function getLeftTorso(): MechdefPart
    {
        return $this->parts[MechEntity::LOCATION_LEFT_TORSO];
    }

    public function getRightArm(): MechdefPart
    {
        return $this->parts[MechEntity::LOCATION_RIGHT_ARM];
    }

    public function getRightLeg(): MechdefPart
    {
        return $this->parts[MechEntity::LOCATION_RIGHT_LEG];
    }

    public function getRightTorso(): MechdefPart
    {
        return $this->parts[MechEntity::LOCATION_RIGHT_TORSO];
    }
}
