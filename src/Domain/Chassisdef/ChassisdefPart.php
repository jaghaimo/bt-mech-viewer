<?php

declare(strict_types=1);

namespace Btmv\Domain\Chassisdef;

final class ChassisdefPart
{
    /** @var ChassisdefHardpoints */
    private $hardpoints;

    /** @var int */
    private $internalStructure;

    /** @var string */
    private $location;

    /** @var int */
    private $maxArmorFront;

    /** @var int */
    private $maxArmorRear;

    /**
     * @param array $parts
     */
    public function __construct(array $parts)
    {
        $this->hardpoints = new ChassisdefHardpoints($parts['Hardpoints']);
        $this->location = $parts['Location'];
        $this->maxArmorFront = $parts['MaxArmor'];
        $this->maxArmorRear = $parts['MaxRearArmor'];
        $this->internalStructure = $parts['InternalStructure'];
    }

    /**
     * @param string $hardpointType
     *
     * @return int
     */
    public function getHardpoints(string $hardpointType): int
    {
        return $this->hardpoints->getHardpoints($hardpointType);
    }

    /**
     * @return int
     */
    public function getInternalStructure(): int
    {
        return $this->internalStructure;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @return int
     */
    public function getMaxArmorFront(): int
    {
        return $this->maxArmorFront;
    }

    /**
     * @return int
     */
    public function getMaxArmorRear(): int
    {
        return $this->maxArmorRear;
    }
}
