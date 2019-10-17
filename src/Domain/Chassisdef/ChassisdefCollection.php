<?php

namespace Btmv\Domain\Chassisdef;

class ChassisdefCollection
{
    /**
     * @var bool
     */
    private $isSorted = false;

    /**
     * @var ChassisdefEntity[]
     */
    private $chassisdefEntities = [];

    /**
     * @var ChassisdefFilter
     */
    private $chassisdefFilter;

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
    public function add(ChassisdefEntity $chassisdefEntity)
    {
        $this->totalCount++;

        if ($this->chassisdefFilter->isMatching($chassisdefEntity)) {
            $this->matchingCount++;
            $key = $chassisdefEntity->getId();
            $this->chassisdefEntities[$key] = $chassisdefEntity;
            $this->isSorted = false;
        }
    }

    /**
     * @return ChassisdefEntity[]
     */
    public function getAll()
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

    /**
     * @param ChassisdefEntity[] $chasisDefEntities
     * @param ChassisdefFilter $chassisdefFilter
     *
     * @return ChassisdefCollection
     */
    public static function fromArray(array $chasisDefEntities, ChassisdefFilter $chassisdefFilter)
    {
        $collection = new self($chassisdefFilter);

        foreach ($chasisDefEntities as $chasisDefEntity) {
            if ($chasisDefEntity instanceof ChassisdefEntity) {
                $collection->add($chasisDefEntity);
            }
        }

        return $collection;
    }

    private function sort(): void
    {
        if ($this->isSorted) {
            return;
        }

        uasort($this->chassisdefEntities, function (ChassisdefEntity $entity1, ChassisdefEntity $entity2) {
            if ($entity1->getTonnage() !== $entity2->getTonnage()) {
                return $entity1->getTonnage() <=> $entity2->getTonnage();
            }

            if ($entity1->getName() !== $entity2->getName()) {
                return $entity1->getName() <=> $entity2->getName();
            }

            return $entity1->getVariant() <=> $entity2->getVariant();
        });
    }
}
