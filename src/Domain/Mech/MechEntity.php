<?php

declare(strict_types=1);

namespace Btmv\Domain\Mech;

use Btmv\Domain\Chassisdef\ChassisdefEntity;
use Btmv\Domain\Mechdef\MechdefEntity;

final class MechEntity
{
    const LOCATION_CENTER_TORSO = 'CenterTorso';
    const LOCATION_HEAD = 'Head';
    const LOCATION_LEFT_ARM = 'LeftArm';
    const LOCATION_LEFT_LEG = 'LeftLeg';
    const LOCATION_LEFT_TORSO = 'LeftTorso';
    const LOCATION_RIGHT_ARM = 'RightArm';
    const LOCATION_RIGHT_LEG = 'RightLeg';
    const LOCATION_RIGHT_TORSO = 'RightTorso';

    private ChassisdefEntity $chassisdefEntity;
    private MechdefEntity $mechdefEntity;

    public function __construct(ChassisdefEntity $chassisdefEntity, MechdefEntity $mechdefEntity)
    {
        $this->chassisdefEntity = $chassisdefEntity;
        $this->mechdefEntity = $mechdefEntity;
    }

    public function getChassisdefEntity(): ChassisdefEntity
    {
        return $this->chassisdefEntity;
    }

    public function getMechdefEntity(): MechdefEntity
    {
        return $this->mechdefEntity;
    }
}
