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

    public function __construct(array $chasisdefEntities, MechdefFilter $mechdefFilter)
    {
        foreach ($chasisdefEntities as $chasisdefEntity) {
            $this->add($chasisdefEntity, $mechdefFilter);
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

    /**
     * @return int
     */
    public function getMatchingCount(): int
    {
        return $this->matchingCount;
    }

    /**
     * @return int
     */
    public function getTotalCount(): int
    {
        return $this->totalCount;
    }

    private function add(MechdefEntity $mechdefEntity, MechdefFilter $mechdefFilter): void
    {
        ++$this->totalCount;

        if ($mechdefFilter->isMatching($mechdefEntity)) {
            ++$this->matchingCount;
            $key = $mechdefEntity->getId();
            $this->mechdefEntities[$key] = $mechdefEntity;
            $this->isSorted = false;
        }
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
