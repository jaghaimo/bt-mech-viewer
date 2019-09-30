<?php

namespace Btmv\Domain\Mech;

class MechPart
{
    /** @var MechHardpoints */
    private $hardpoints;

    /** @var int */
    private $maxArmorFront;

    /** @var int */
    private $maxArmorRear;

    /** @var int */
    private $internalStructure;

    /**
     * @param MechHardpoints $hardpoints
     * @param int $maxArmorFront
     * @param int $maxArmorRear
     * @param int $internalStructure
     */
    public function __construct(
        MechHardpoints $hardpoints,
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
     * @return MechPart
     */
    public static function fromArray(array $array): MechPart
    {
        $arrayLower = array_change_key_case($array, CASE_LOWER);

        return new self(
            MechHardpoints::fromArray($arrayLower['hardpoints']),
            $arrayLower['maxarmor'],
            $arrayLower['maxreararmor'],
            $arrayLower['internalstructure']
        );
    }

    /**
     * @return MechPart
     */
    public static function makeEmpty(): MechPart
    {
        return new self(new MechHardpoints(), 0, 0, 0);
    }
}
