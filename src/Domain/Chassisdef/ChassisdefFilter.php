<?php

declare(strict_types=1);

namespace Btmv\Domain\Chassisdef;

final class ChassisdefFilter
{
    private ?string $bundle = null;
    private ?string $class = null;
    private ?int $tonnage = null;

    public function isMatching(ChassisdefEntity $chassisdefEntity): bool
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
