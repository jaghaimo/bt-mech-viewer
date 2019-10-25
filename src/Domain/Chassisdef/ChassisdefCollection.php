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
     * @var ChassisdefFilter
     */
    private $chassisdefFilter;

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
     * @param ChassisdefFilter $chassisdefFilter
     */
    public function __construct(ChassisdefFilter $chassisdefFilter)
    {
        $this->chassisdefFilter = $chassisdefFilter;
    }

    /**
     * @param ChassisdefEntity $chassisdefEntity
     */
    public function add(ChassisdefEntity $chassisdefEntity): void
    {
        ++$this->totalCount;

        if ($this->chassisdefFilter->isMatching($chassisdefEntity)) {
            ++$this->matchingCount;
            $key = $chassisdefEntity->getId();
            $this->chassisdefEntities[$key] = $chassisdefEntity;
            $this->isSorted = false;
        }
    }

    /**
     * @param ChassisdefEntity[] $chasisdefEntities
     * @param ChassisdefFilter   $chassisdefFilter
     *
     * @return ChassisdefCollection
     *
     * @psalm-suppress RedundantConditionGivenDocblockType
     */
    public static function fromArray(array $chasisdefEntities, ChassisdefFilter $chassisdefFilter)
    {
        $collection = new self($chassisdefFilter);

        foreach ($chasisdefEntities as $chasisdefEntity) {
            if ($chasisdefEntity instanceof ChassisdefEntity) {
                $collection->add($chasisdefEntity);
            }
        }

        return $collection;
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
