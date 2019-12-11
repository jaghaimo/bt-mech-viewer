<?php

declare(strict_types=1);

namespace Btmv\Domain\Chassisdef;

final class ChassisdefFilter
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
     * @return bool
     */
    public function isMatching(ChassisdefEntity $chassisdefEntity)
    {
        $isNotBlacklisted = !$chassisdefEntity->getTags()->isBlacklisted();
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

        return $isNotBlacklisted && $isMatchingBundle && $isMatchingClass && $isMatchingTonnage;
    }

    public function setBundle(?string $bundle): void
    {
        $this->bundle = $bundle;
    }

    public function setClass(?string $class): void
    {
        $this->class = $class;
    }

    public function setTonnage(?int $tonnage): void
    {
        $this->tonnage = $tonnage;
    }
}
