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
     * @var MechdefFilter
     */
    private $mechdefFilter;

    /**
     * @var int
     */
    private $totalCount = 0;

    /**
     * @param MechdefFilter $mechdefFilter
     */
    public function __construct(MechdefFilter $mechdefFilter)
    {
        $this->mechdefFilter = $mechdefFilter;
    }

    /**
     * @param MechdefEntity $mechdefEntity
     */
    public function add(MechdefEntity $mechdefEntity): void
    {
        ++$this->totalCount;

        if ($this->mechdefFilter->isMatching($mechdefEntity)) {
            ++$this->matchingCount;
            $key = $mechdefEntity->getId();
            $this->mechdefEntities[$key] = $mechdefEntity;
            $this->isSorted = false;
        }
    }

    /**
     * @param MechdefEntity[] $chasisdefEntities
     * @param MechdefFilter   $mechdefFilter
     *
     * @return MechdefCollection
     *
     * @psalm-suppress RedundantConditionGivenDocblockType
     */
    public static function fromArray(array $chasisdefEntities, MechdefFilter $mechdefFilter)
    {
        $collection = new self($mechdefFilter);

        foreach ($chasisdefEntities as $chasisdefEntity) {
            if ($chasisdefEntity instanceof MechdefEntity) {
                $collection->add($chasisdefEntity);
            }
        }

        return $collection;
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
