<?php

declare(strict_types=1);

namespace Btmv\Domain\Chassisdef;

final class ChassisdefLocations
{
    const LOCATION_CENTER_TORSO = 'centertorso';
    const LOCATION_HEAD = 'head';
    const LOCATION_LEFT_ARM = 'leftarm';
    const LOCATION_LEFT_LEG = 'leftleg';
    const LOCATION_LEFT_TORSO = 'lefttorso';
    const LOCATION_RIGHT_ARM = 'rightarm';
    const LOCATION_RIGHT_LEG = 'rightleg';
    const LOCATION_RIGHT_TORSO = 'righttorso';

    /**
     * @var ChassisdefPart
     */
    private $centerTorso;

    /**
     * @var ChassisdefPart
     */
    private $head;

    /**
     * @var ChassisdefPart
     */
    private $leftArm;

    /**
     * @var ChassisdefPart
     */
    private $leftLeg;

    /**
     * @var ChassisdefPart
     */
    private $leftTorso;

    /**
     * @var ChassisdefPart
     */
    private $rightArm;

    /**
     * @var ChassisdefPart
     */
    private $rightLeg;

    /**
     * @var ChassisdefPart
     */
    private $rightTorso;

    public function __construct()
    {
        $this->head = ChassisdefPart::makeEmpty();
        $this->leftArm = ChassisdefPart::makeEmpty();
        $this->leftTorso = ChassisdefPart::makeEmpty();
        $this->centerTorso = ChassisdefPart::makeEmpty();
        $this->rightTorso = ChassisdefPart::makeEmpty();
        $this->rightArm = ChassisdefPart::makeEmpty();
        $this->leftLeg = ChassisdefPart::makeEmpty();
        $this->rightLeg = ChassisdefPart::makeEmpty();
    }

    /**
     * @param array $locations
     *
     * @throws ChassisdefException
     *
     * @return ChassisdefLocations
     */
    public static function fromArray(array $locations): ChassisdefLocations
    {
        $chassisdefLocations = new self();

        foreach ($locations as $location) {
            $arrayLower = array_change_key_case($location, CASE_LOWER);
            $chassisdefPart = ChassisdefPart::fromArray($arrayLower);
            $normalizedLocation = strtolower($arrayLower['location']);

            switch ($normalizedLocation) {
                case self::LOCATION_HEAD:
                    $chassisdefLocations->setHead($chassisdefPart);

                    break;
                case self::LOCATION_LEFT_ARM:
                    $chassisdefLocations->setLeftArm($chassisdefPart);

                    break;
                case self::LOCATION_LEFT_TORSO:
                    $chassisdefLocations->setLeftTorso($chassisdefPart);

                    break;
                case self::LOCATION_CENTER_TORSO:
                    $chassisdefLocations->setCenterTorso($chassisdefPart);

                    break;
                case self::LOCATION_RIGHT_TORSO:
                    $chassisdefLocations->setRightTorso($chassisdefPart);

                    break;
                case self::LOCATION_RIGHT_ARM:
                    $chassisdefLocations->setRightArm($chassisdefPart);

                    break;
                case self::LOCATION_LEFT_LEG:
                    $chassisdefLocations->setLeftLeg($chassisdefPart);

                    break;
                case self::LOCATION_RIGHT_LEG:
                    $chassisdefLocations->setRightLeg($chassisdefPart);

                    break;
                default:
                    throw ChassisdefException::invalidChassisdefLocation($normalizedLocation);
            }
        }

        return $chassisdefLocations;
    }

    /**
     * @return ChassisdefPart
     */
    public function getCenterTorso(): ChassisdefPart
    {
        return $this->centerTorso;
    }

    /**
     * @return ChassisdefPart
     */
    public function getHead(): ChassisdefPart
    {
        return $this->head;
    }

    /**
     * @return ChassisdefPart
     */
    public function getLeftArm(): ChassisdefPart
    {
        return $this->leftArm;
    }

    /**
     * @return ChassisdefPart
     */
    public function getLeftLeg(): ChassisdefPart
    {
        return $this->leftLeg;
    }

    /**
     * @return ChassisdefPart
     */
    public function getLeftTorso(): ChassisdefPart
    {
        return $this->leftTorso;
    }

    /**
     * @return ChassisdefPart
     */
    public function getRightArm(): ChassisdefPart
    {
        return $this->rightArm;
    }

    /**
     * @return ChassisdefPart
     */
    public function getRightLeg(): ChassisdefPart
    {
        return $this->rightLeg;
    }

    /**
     * @return ChassisdefPart
     */
    public function getRightTorso(): ChassisdefPart
    {
        return $this->rightTorso;
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

        // correct omni hardpoints
        return $hardpoints < 0 ? 22 : $hardpoints;
    }

    /**
     * @param ChassisdefPart $centerTorso
     */
    public function setCenterTorso(ChassisdefPart $centerTorso): void
    {
        $this->centerTorso = $centerTorso;
    }

    /**
     * @param ChassisdefPart $head
     */
    public function setHead(ChassisdefPart $head): void
    {
        $this->head = $head;
    }

    /**
     * @param ChassisdefPart $leftArm
     */
    public function setLeftArm(ChassisdefPart $leftArm): void
    {
        $this->leftArm = $leftArm;
    }

    /**
     * @param ChassisdefPart $leftLeg
     */
    public function setLeftLeg(ChassisdefPart $leftLeg): void
    {
        $this->leftLeg = $leftLeg;
    }

    /**
     * @param ChassisdefPart $leftTorso
     */
    public function setLeftTorso(ChassisdefPart $leftTorso): void
    {
        $this->leftTorso = $leftTorso;
    }

    /**
     * @param ChassisdefPart $rightArm
     */
    public function setRightArm(ChassisdefPart $rightArm): void
    {
        $this->rightArm = $rightArm;
    }

    /**
     * @param ChassisdefPart $rightLeg
     */
    public function setRightLeg(ChassisdefPart $rightLeg): void
    {
        $this->rightLeg = $rightLeg;
    }

    /**
     * @param ChassisdefPart $rightTorso
     */
    public function setRightTorso(ChassisdefPart $rightTorso): void
    {
        $this->rightTorso = $rightTorso;
    }
}
