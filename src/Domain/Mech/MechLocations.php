<?php

namespace Btmv\Domain\Mech;

class MechLocations
{
    const LOCATION_HEAD = 'head';
    const LOCATION_LEFT_ARM = 'leftarm';
    const LOCATION_LEFT_TORSO = 'lefttorso';
    const LOCATION_CENTER_TORSO = 'centertorso';
    const LOCATION_RIGHT_TORSO = 'righttorso';
    const LOCATION_RIGHT_ARM = 'rightarm';
    const LOCATION_LEFT_LEG = 'leftleg';
    const LOCATION_RIGHT_LEG = 'rightleg';

    /**
     * @var MechPart
     */
    private $head;

    /**
     * @var MechPart
     */
    private $leftArm;

    /**
     * @var MechPart
     */
    private $leftTorso;

    /**
     * @var MechPart
     */
    private $centerTorso;

    /**
     * @var MechPart
     */
    private $rightTorso;

    /**
     * @var MechPart
     */
    private $rightArm;

    /**
     * @var MechPart
     */
    private $leftLeg;

    /**
     * @var MechPart
     */
    private $rightLeg;

    public function __construct()
    {
        $this->head = MechPart::makeEmpty();
        $this->leftArm = MechPart::makeEmpty();
        $this->leftTorso = MechPart::makeEmpty();
        $this->centerTorso = MechPart::makeEmpty();
        $this->rightTorso = MechPart::makeEmpty();
        $this->rightArm = MechPart::makeEmpty();
        $this->leftLeg = MechPart::makeEmpty();
        $this->rightLeg = MechPart::makeEmpty();
    }

    /**
     * @return MechPart
     */
    public function getHead(): MechPart
    {
        return $this->head;
    }

    /**
     * @return MechPart
     */
    public function getLeftArm(): MechPart
    {
        return $this->leftArm;
    }

    /**
     * @return MechPart
     */
    public function getLeftTorso(): MechPart
    {
        return $this->leftTorso;
    }

    /**
     * @return MechPart
     */
    public function getCenterTorso(): MechPart
    {
        return $this->centerTorso;
    }

    /**
     * @return MechPart
     */
    public function getRightTorso(): MechPart
    {
        return $this->rightTorso;
    }

    /**
     * @return MechPart
     */
    public function getRightArm(): MechPart
    {
        return $this->rightArm;
    }

    /**
     * @return MechPart
     */
    public function getLeftLeg(): MechPart
    {
        return $this->leftLeg;
    }

    /**
     * @return MechPart
     */
    public function getRightLeg(): MechPart
    {
        return $this->rightLeg;
    }

    /**
     * @param string $hardpointType
     *
     * @return int
     */
    public function getTotalHardpoints(string $hardpointType): int
    {
        $hardpoints = 0;

        $hardpoints += $this->head->getHardpoints($hardpointType);
        $hardpoints += $this->leftArm->getHardpoints($hardpointType);
        $hardpoints += $this->leftTorso->getHardpoints($hardpointType);
        $hardpoints += $this->centerTorso->getHardpoints($hardpointType);
        $hardpoints += $this->rightTorso->getHardpoints($hardpointType);
        $hardpoints += $this->rightArm->getHardpoints($hardpointType);
        $hardpoints += $this->leftLeg->getHardpoints($hardpointType);
        $hardpoints += $this->rightLeg->getHardpoints($hardpointType);

        return $hardpoints;
    }

    /**
     * @param MechPart $head
     */
    public function setHead(MechPart $head): void
    {
        $this->head = $head;
    }

    /**
     * @param MechPart $leftArm
     */
    public function setLeftArm(MechPart $leftArm): void
    {
        $this->leftArm = $leftArm;
    }

    /**
     * @param MechPart $leftTorso
     */
    public function setLeftTorso(MechPart $leftTorso): void
    {
        $this->leftTorso = $leftTorso;
    }

    /**
     * @param MechPart $centerTorso
     */
    public function setCenterTorso(MechPart $centerTorso): void
    {
        $this->centerTorso = $centerTorso;
    }

    /**
     * @param MechPart $rightTorso
     */
    public function setRightTorso(MechPart $rightTorso): void
    {
        $this->rightTorso = $rightTorso;
    }

    /**
     * @param MechPart $rightArm
     */
    public function setRightArm(MechPart $rightArm): void
    {
        $this->rightArm = $rightArm;
    }

    /**
     * @param MechPart $leftLeg
     */
    public function setLeftLeg(MechPart $leftLeg): void
    {
        $this->leftLeg = $leftLeg;
    }

    /**
     * @param MechPart $rightLeg
     */
    public function setRightLeg(MechPart $rightLeg): void
    {
        $this->rightLeg = $rightLeg;
    }

    /**
     * @param array $array
     *
     * @return MechLocations
     *
     * @throws MechException
     */
    public static function fromArray(array $array): MechLocations
    {
        $mechLocations = new self();

        foreach ($array as $location) {
            $arrayLower = array_change_key_case($location, CASE_LOWER);
            $mechPart = MechPart::fromArray($arrayLower);
            $mechLocation = strtolower($arrayLower['location']);

            switch ($mechLocation) {
                case self::LOCATION_HEAD:
                    $mechLocations->setHead($mechPart);
                    break;
                case self::LOCATION_LEFT_ARM:
                    $mechLocations->setLeftArm($mechPart);
                    break;
                case self::LOCATION_LEFT_TORSO:
                    $mechLocations->setLeftTorso($mechPart);
                    break;
                case self::LOCATION_CENTER_TORSO:
                    $mechLocations->setCenterTorso($mechPart);
                    break;
                case self::LOCATION_RIGHT_TORSO:
                    $mechLocations->setRightTorso($mechPart);
                    break;
                case self::LOCATION_RIGHT_ARM:
                    $mechLocations->setRightArm($mechPart);
                    break;
                case self::LOCATION_LEFT_LEG:
                    $mechLocations->setLeftLeg($mechPart);
                    break;
                case self::LOCATION_RIGHT_LEG:
                    $mechLocations->setRightLeg($mechPart);
                    break;
                default:
                    throw MechException::invalidMechLocation($mechLocation);
            }
        }

        return $mechLocations;
    }
}
