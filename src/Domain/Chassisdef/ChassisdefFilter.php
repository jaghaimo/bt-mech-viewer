<?php

declare(strict_types=1);

namespace Btmv\Domain\Chassisdef;

class ChassisdefFilter
{
    /**
     * @var null|string
     */
    private $bundle;

    /**
     * @var null|string
     */
    private $class;

    /**
     * @var null|int
     */
    private $tonnage;

    /**
     * @param ChassisdefEntity $chassisdefEntity
     *
     * @return bool
     */
    public function isMatching(ChassisdefEntity $chassisdefEntity)
    {
        $isMatchingBundle = true;
        $isMatchingClass = true;
        $isMatchingTonnage = true;

        if ($this->bundle) {
            $isMatchingBundle = 0 === strcasecmp($chassisdefEntity->getBundle(), $this->bundle);
        }

        if ($this->class) {
            $isMatchingClass = 0 === strcasecmp($chassisdefEntity->getClass(), $this->class);
        }

        if ($this->tonnage) {
            $isMatchingTonnage = $chassisdefEntity->getTonnage() === $this->tonnage;
        }

        return $isMatchingBundle && $isMatchingClass && $isMatchingTonnage;
    }

    /**
     * @param null|string $bundle
     */
    public function setBundle(?string $bundle): void
    {
        $this->bundle = $bundle;
    }

    /**
     * @param null|string $class
     */
    public function setClass(?string $class): void
    {
        $this->class = $class;
    }

    /**
     * @param null|int $tonnage
     */
    public function setTonnage(?int $tonnage): void
    {
        $this->tonnage = $tonnage;
    }
}
