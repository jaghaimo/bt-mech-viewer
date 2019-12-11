<?php

declare(strict_types=1);

namespace Btmv\Domain\Chassisdef;

use Btmv\Domain\FilterAwareCollection;

final class ChassisdefCollection implements FilterAwareCollection
{
    /**
     * @var ChassisdefEntity[]
     */
    private $chassisdefEntities = [];

    /**
     * @var bool
     */
    private $isSorted = false;
    /**
     * @var int
     */
    private $matchingCount = 0;

    /**
     * @var int
     */
    private $totalCount = 0;

    /**
     * @param ChassisdefEntity[] $chasisdefEntities
     *
     * @return ChassisdefCollection
     */
    public function __construct(array $chasisdefEntities, ChassisdefFilter $chassisdefFilter)
    {
        foreach ($chasisdefEntities as $chasisdefEntity) {
            $this->add($chasisdefEntity, $chassisdefFilter);
        }
    }

    public function add(ChassisdefEntity $chassisdefEntity, ChassisdefFilter $chassisdefFilter): void
    {
        ++$this->totalCount;

        if ($chassisdefFilter->isMatching($chassisdefEntity)) {
            ++$this->matchingCount;
            $key = $chassisdefEntity->getId();
            $this->chassisdefEntities[$key] = $chassisdefEntity;
            $this->isSorted = false;
        }
    }

    /**
     * @return ChassisdefEntity[]
     */
    public function getAll(): array
    {
        if (!$this->isSorted) {
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
