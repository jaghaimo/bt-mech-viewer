<?php

declare(strict_types=1);

namespace Btmv\Domain\Chassisdef;

final class ChassisdefPart
{
    private ChassisdefHardpoints $hardpoints;
    private int $internalStructure;
    private string $location;
    private int $maxArmorFront;
    private int $maxArmorRear;

    public function __construct(array $parts)
    {
        $this->hardpoints = new ChassisdefHardpoints($parts['Hardpoints']);
        $this->location = $parts['Location'];
        $this->maxArmorFront = $parts['MaxArmor'];
        $this->maxArmorRear = $parts['MaxRearArmor'];
        $this->internalStructure = $parts['InternalStructure'];
    }

    public function getHardpoints(string $hardpointType): int
    {
        return $this->hardpoints->getHardpoints($hardpointType);
    }

    public function getInternalStructure(): int
    {
        return $this->internalStructure;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getMaxArmorFront(): int
    {
        return $this->maxArmorFront;
    }

    public function getMaxArmorRear(): int
    {
        return $this->maxArmorRear;
    }
}
