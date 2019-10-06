<?php

namespace Btmv\Domain\Chassisdef;

class ChassisdefPart
{
    /** @var ChassisdefHardpoints */
    private $hardpoints;

    /** @var int */
    private $maxArmorFront;

    /** @var int */
    private $maxArmorRear;

    /** @var int */
    private $internalStructure;

    /**
     * @param ChassisdefHardpoints $hardpoints
     * @param int $maxArmorFront
     * @param int $maxArmorRear
     * @param int $internalStructure
     */
    public function __construct(
        ChassisdefHardpoints $hardpoints,
        int $maxArmorFront,
        int $maxArmorRear,
        int $internalStructure
    ) {
        $this->hardpoints = $hardpoints;
        $this->maxArmorFront = $maxArmorFront;
        $this->maxArmorRear = $maxArmorRear;
        $this->internalStructure = $internalStructure;
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

    /**
     * @return int
     */
    public function getInternalStructure(): int
    {
        return $this->internalStructure;
    }

    /**
     * @param array $array
     *
     * @return ChassisdefPart
     */
    public static function fromArray(array $array): ChassisdefPart
    {
        $arrayLower = array_change_key_case($array, CASE_LOWER);

        return new self(
            ChassisdefHardpoints::fromArray($arrayLower['hardpoints']),
            $arrayLower['maxarmor'],
            $arrayLower['maxreararmor'],
            $arrayLower['internalstructure']
        );
    }

    /**
     * @return ChassisdefPart
     */
    public static function makeEmpty(): ChassisdefPart
    {
        return new self(new ChassisdefHardpoints(), 0, 0, 0);
    }
}
