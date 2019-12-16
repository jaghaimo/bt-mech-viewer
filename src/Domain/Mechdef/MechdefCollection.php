<?php

declare(strict_types=1);

namespace Btmv\Domain\Mechdef;

use Btmv\Domain\FilterAwareCollection;

final class MechdefCollection implements FilterAwareCollection
{
    /**
     * @var bool
     */
    private $isSorted = false;
    /**
     * @var int
     */
    private $matchingCount = 0;
    /**
     * @var MechdefEntity[]
     */
    private $mechdefEntities = [];

    /**
     * @var int
     */
    private $totalCount = 0;

    public function add(MechdefEntity $mechdefEntity, MechdefFilter $mechdefFilter): void
    {
        ++$this->totalCount;

        if ($mechdefFilter->isMatching($mechdefEntity)) {
            ++$this->matchingCount;
            $key = $mechdefEntity->getId();
            $this->mechdefEntities[$key] = $mechdefEntity;
            $this->isSorted = false;
        }
    }

    /**
     * @return MechdefEntity[]
     */
    public function getAll(): array
    {
        if (!$this->isSorted) {
            $this->sort();
        }

        return $this->mechdefEntities;
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
            $this->mechdefEntities,
            function (MechdefEntity $entity1, MechdefEntity $entity2) {
                return $entity1->getId() <=> $entity2->getId();
            }
        );
    }
}
