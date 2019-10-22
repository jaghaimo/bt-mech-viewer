<?php

declare(strict_types=1);

namespace Btmv\Domain\Chassisdef;

class ChassisdefHardpoints
{
    const HARDPOINT_ANTI_PERSONNEL = 'antipersonnel';
    const HARDPOINT_BALLISTIC = 'ballistic';
    const HARDPOINT_ENERGY = 'energy';
    const HARDPOINT_MISSILE = 'missile';

    /**
     * @var int
     */
    private $antiPersonnel = 0;
    /**
     * @var int
     */
    private $ballistic = 0;

    /**
     * @var int
     */
    private $energy = 0;
    /**
     * @var bool
     */
    private $isOmni = false;
    /**
     * @var int
     */
    private $missile = 0;

    public function addAntiPersonnel(): void
    {
        ++$this->antiPersonnel;
    }

    public function addBallistic(): void
    {
        ++$this->ballistic;
    }

    public function addEnergy(): void
    {
        ++$this->energy;
    }

    public function addMissile(): void
    {
        ++$this->missile;
    }

    /**
     * @param array $array
     *
     * @throws ChassisdefException
     *
     * @return ChassisdefHardpoints
     */
    public static function fromArray(array $array): ChassisdefHardpoints
    {
        $mechHardpoints = new self();

        foreach ($array as $hardpoint) {
            $arrayLower = array_change_key_case($hardpoint, CASE_LOWER);
            $isOmni = $arrayLower['omni'];
            $weaponMount = strtolower($arrayLower['weaponmount']);

            if ($isOmni) {
                $mechHardpoints->setOmni($isOmni);

                break;
            }

            switch ($weaponMount) {
                case self::HARDPOINT_ANTI_PERSONNEL:
                    $mechHardpoints->addAntiPersonnel();

                    break;
                case self::HARDPOINT_BALLISTIC:
                    $mechHardpoints->addBallistic();

                    break;
                case self::HARDPOINT_ENERGY:
                    $mechHardpoints->addEnergy();

                    break;
                case self::HARDPOINT_MISSILE:
                    $mechHardpoints->addMissile();

                    break;
                default:
                    throw ChassisdefException::invalidChassisdefHardpoint($weaponMount);
            }
        }

        return $mechHardpoints;
    }

    /**
     * @param string $hardpointType
     *
     * @throws ChassisdefException
     *
     * @return int
     */
    public function getHardpoints(string $hardpointType): int
    {
        if ($this->isOmni) {
            return -1;
        }

        switch ($hardpointType) {
            case self::HARDPOINT_ANTI_PERSONNEL:
                return $this->antiPersonnel;
            case self::HARDPOINT_BALLISTIC:
                return $this->ballistic;
            case self::HARDPOINT_ENERGY:
                return $this->energy;
            case self::HARDPOINT_MISSILE:
                return $this->missile;
            default:
                throw ChassisdefException::invalidChassisdefHardpoint($hardpointType);
        }
    }

    /**
     * @param bool $isOmni
     */
    public function setOmni(bool $isOmni): void
    {
        $this->isOmni = $isOmni;
    }
}
