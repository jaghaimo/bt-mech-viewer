<?php

declare(strict_types=1);

namespace Btmv\Domain\Chassisdef;

use Btmv\Domain\Mech\MechEntity;

final class ChassisdefLocations
{
    /** @var ChassisdefPart[] */
    private $parts = [];

    public function __construct(array $chassisdefLocations)
    {
        foreach ($chassisdefLocations as $chassisdefLocation) {
            $part = new ChassisdefPart($chassisdefLocation);
            $location = $part->getLocation();
            $this->parts[$location] = $part;
        }
    }

    public function getCenterTorso(): ChassisdefPart
    {
        return $this->parts[MechEntity::LOCATION_CENTER_TORSO];
    }

    public function getHead(): ChassisdefPart
    {
        return $this->parts[MechEntity::LOCATION_HEAD];
    }

    public function getLeftArm(): ChassisdefPart
    {
        return $this->parts[MechEntity::LOCATION_LEFT_ARM];
    }

    public function getLeftLeg(): ChassisdefPart
    {
        return $this->parts[MechEntity::LOCATION_LEFT_LEG];
    }

    public function getLeftTorso(): ChassisdefPart
    {
        return $this->parts[MechEntity::LOCATION_LEFT_TORSO];
    }

    public function getRightArm(): ChassisdefPart
    {
        return $this->parts[MechEntity::LOCATION_RIGHT_ARM];
    }

    public function getRightLeg(): ChassisdefPart
    {
        return $this->parts[MechEntity::LOCATION_RIGHT_LEG];
    }

    public function getRightTorso(): ChassisdefPart
    {
        return $this->parts[MechEntity::LOCATION_RIGHT_TORSO];
    }

    public function getTotalHardpoints(string $hardpointType): int
    {
        $hardpoints = 0;

        $hardpoints += $this->getHead()->getHardpoints($hardpointType);
        $hardpoints += $this->getLeftArm()->getHardpoints($hardpointType);
        $hardpoints += $this->getLeftTorso()->getHardpoints($hardpointType);
        $hardpoints += $this->getCenterTorso()->getHardpoints($hardpointType);
        $hardpoints += $this->getRightTorso()->getHardpoints($hardpointType);
        $hardpoints += $this->getRightArm()->getHardpoints($hardpointType);
        $hardpoints += $this->getLeftLeg()->getHardpoints($hardpointType);
        $hardpoints += $this->getRightLeg()->getHardpoints($hardpointType);

        // correct omni hardpoints
        return $hardpoints < 0 ? 22 : $hardpoints;
    }
}
