<?php

declare(strict_types=1);

namespace Btmv\Domain\Mech;

use Btmv\Domain\FilterAwareCollection;

final class MechCollection implements FilterAwareCollection
{
    private bool $isSorted = false;
    private int $matchingCount = 0;
    /** @var MechEntity[] */
    private array $mechEntities = [];
    private int $totalCount = 0;

    public function add(MechEntity $mechEntity, MechFilter $mechFilter): void
    {
        ++$this->totalCount;

        if ($mechFilter->isMatching($mechEntity)) {
            ++$this->matchingCount;
            $this->mechEntities[] = $mechEntity;
            $this->isSorted = false;
        }
    }

    /**
     * @return MechEntity[]
     */
    public function getAll(): array
    {
        if (!$this->isSorted) {
            $this->sort();
        }

        return $this->mechEntities;
    }

    public function getMatchingCount(): int
    {
        return $this->matchingCount;
    }

    public function getTotalCount(): int
    {
        return $this->totalCount;
    }

    private function sort(): void
    {
        if ($this->isSorted) {
            return;
        }

        uasort(
            $this->mechEntities,
            function (MechEntity $mech1, MechEntity $mech2) {
                $entity1 = $mech1->getChassisdefEntity();
                $entity2 = $mech2->getChassisdefEntity();
                if ($entity1->getTonnage() !== $entity2->getTonnage()) {
                    return $entity1->getTonnage() <=> $entity2->getTonnage();
                }

                if ($entity1->getName() !== $entity2->getName()) {
                    return $entity1->getName() <=> $entity2->getName();
                }

                return $entity1->getVariant() <=> $entity2->getVariant();
            }
        );
    }
}
