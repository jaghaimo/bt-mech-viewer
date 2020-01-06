<?php

declare(strict_types=1);

namespace Btmv\Domain\Mechdef;

use Btmv\Domain\FilterAwareCollection;

final class MechdefCollection implements FilterAwareCollection
{
    private bool $isSorted = false;
    private int $matchingCount = 0;
    /** @var MechdefEntity[] */
    private array $mechdefEntities = [];
    private int $totalCount = 0;

    public function add(MechdefEntity $mechdefEntity, ?MechdefFilter $mechdefFilter): void
    {
        ++$this->totalCount;
        $isMatching = is_null($mechdefFilter) || $mechdefFilter->isMatching($mechdefEntity);

        if ($isMatching) {
            ++$this->matchingCount;
            $key = $mechdefEntity->getId();
            $this->mechdefEntities[$key] = $mechdefEntity;
            $this->isSorted = false;
        }
    }

    /**
     * @return MechdefEntity[]
     */
    public function getAll(bool $wantsSorting = true): array
    {
        $needsSorting = $wantsSorting && !$this->isSorted;

        if ($needsSorting) {
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
