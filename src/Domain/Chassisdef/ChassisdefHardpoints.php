<?php

declare(strict_types=1);

namespace Btmv\Domain\Chassisdef;

final class ChassisdefHardpoints
{
    const HARDPOINT_ANTI_PERSONNEL = 'antipersonnel';
    const HARDPOINT_BALLISTIC = 'ballistic';
    const HARDPOINT_ENERGY = 'energy';
    const HARDPOINT_MISSILE = 'missile';

    private int $antiPersonnel = 0;
    private int $ballistic = 0;
    private int $energy = 0;
    private bool $isOmni = false;
    private int $missile = 0;

    public function __construct(array $hardpoints)
    {
        foreach ($hardpoints as $hardpoint) {
            if (!array_key_exists('WeaponMount', $hardpoint)) {
                continue;
            }

            $isOmni = $hardpoint['Omni'];
            $weaponMount = strtolower($hardpoint['WeaponMount']);

            if ($isOmni) {
                $this->setOmni($isOmni);

                break;
            }

            switch ($weaponMount) {
                case self::HARDPOINT_ANTI_PERSONNEL:
                    $this->addAntiPersonnel();

                    break;
                case self::HARDPOINT_BALLISTIC:
                    $this->addBallistic();

                    break;
                case self::HARDPOINT_ENERGY:
                    $this->addEnergy();

                    break;
                case self::HARDPOINT_MISSILE:
                    $this->addMissile();

                    break;
                default:
                    throw ChassisdefException::invalidChassisdefHardpoint($weaponMount);
            }
        }
    }

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
     * @throws ChassisdefException
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

    public function setOmni(bool $isOmni): void
    {
        $this->isOmni = $isOmni;
    }
}
