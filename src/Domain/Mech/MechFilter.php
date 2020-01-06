<?php

declare(strict_types=1);

namespace Btmv\Domain\Mech;

final class MechFilter
{
    private ?string $class = null;
    private ?int $tonnage = null;

    public function isMatching(MechEntity $mechEntity): bool
    {
        $isNotBlacklisted = !$mechEntity->getChassisdefEntity()->getTags()->isBlacklisted();
        $isMatchingClass = true;
        $isMatchingTonnage = true;

        if ($this->class) {
            $isMatchingClass = 0 === strcasecmp($mechEntity->getChassisdefEntity()->getClass(), $this->class);
        }

        if ($this->tonnage) {
            $isMatchingTonnage = $mechEntity->getChassisdefEntity()->getTonnage() === $this->tonnage;
        }

        return $isNotBlacklisted && $isMatchingClass && $isMatchingTonnage;
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
