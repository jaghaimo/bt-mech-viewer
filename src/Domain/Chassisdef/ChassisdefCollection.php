<?php

declare(strict_types=1);

namespace Btmv\Domain\Chassisdef;

use Btmv\Domain\FilterAwareCollection;

final class ChassisdefCollection implements FilterAwareCollection
{
    /** @var ChassisdefEntity[] */
    private array $chassisdefEntities = [];
    private bool $isSorted = false;
    private int $matchingCount = 0;
    private int $totalCount = 0;

    public function add(ChassisdefEntity $chassisdefEntity, ?ChassisdefFilter $chassisdefFilter): void
    {
        ++$this->totalCount;
        $isMatching = is_null($chassisdefFilter) || $chassisdefFilter->isMatching($chassisdefEntity);

        if ($isMatching) {
            ++$this->matchingCount;
            $key = $chassisdefEntity->getId();
            $this->chassisdefEntities[$key] = $chassisdefEntity;
            $this->isSorted = false;
        }
    }

    public function get(string $key): ?ChassisdefEntity
    {
        return $this->chassisdefEntities[$key] ?? null;
    }

    /**
     * @return ChassisdefEntity[]
     */
    public function getAll(bool $wantsSorting = true): array
    {
        $needsSorting = $wantsSorting && !$this->isSorted;

        if ($needsSorting) {
            $this->sort();
        }

        return $this->chassisdefEntities;
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
            $this->chassisdefEntities,
            function (ChassisdefEntity $entity1, ChassisdefEntity $entity2) {
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
