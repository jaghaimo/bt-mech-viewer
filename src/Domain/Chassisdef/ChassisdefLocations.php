<?php

declare(strict_types=1);

namespace Btmv\Domain\Chassisdef;

final class ChassisdefLocations
{
    const LOCATION_CENTER_TORSO = 'CenterTorso';
    const LOCATION_HEAD = 'Head';
    const LOCATION_LEFT_ARM = 'LeftArm';
    const LOCATION_LEFT_LEG = 'LeftLeg';
    const LOCATION_LEFT_TORSO = 'LeftTorso';
    const LOCATION_RIGHT_ARM = 'RightArm';
    const LOCATION_RIGHT_LEG = 'RightLeg';
    const LOCATION_RIGHT_TORSO = 'RightTorso';

    /**
     * @var ChassisdefPart[]
     */
    private $parts = [];

    /**
     * @param array $chassisdefLocations
     */
    public function __construct(array $chassisdefLocations)
    {
        foreach ($chassisdefLocations as $chassisdefLocation) {
            $part = new ChassisdefPart($chassisdefLocation);
            $location = $part->getLocation();
            $this->parts[$location] = $part;
        }
    }

    /**
     * @return ChassisdefPart
     */
    public function getCenterTorso(): ChassisdefPart
    {
        return $this->parts[self::LOCATION_CENTER_TORSO];
    }

    /**
     * @return ChassisdefPart
     */
    public function getHead(): ChassisdefPart
    {
        return $this->parts[self::LOCATION_HEAD];
    }

    /**
     * @return ChassisdefPart
     */
    public function getLeftArm(): ChassisdefPart
    {
        return $this->parts[self::LOCATION_LEFT_ARM];
    }

    /**
     * @return ChassisdefPart
     */
    public function getLeftLeg(): ChassisdefPart
    {
        return $this->parts[self::LOCATION_LEFT_LEG];
    }

    /**
     * @return ChassisdefPart
     */
    public function getLeftTorso(): ChassisdefPart
    {
        return $this->parts[self::LOCATION_LEFT_TORSO];
    }

    /**
     * @return ChassisdefPart
     */
    public function getRightArm(): ChassisdefPart
    {
        return $this->parts[self::LOCATION_RIGHT_ARM];
    }

    /**
     * @return ChassisdefPart
     */
    public function getRightLeg(): ChassisdefPart
    {
        return $this->parts[self::LOCATION_RIGHT_LEG];
    }

    /**
     * @return ChassisdefPart
     */
    public function getRightTorso(): ChassisdefPart
    {
        return $this->parts[self::LOCATION_RIGHT_TORSO];
    }

    /**
     * @param string $hardpointType
     *
     * @return int
     */
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
