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
     * @param ChassisdefEntity $mechEntity
     */
    public function add(ChassisdefEntity $mechEntity)
    {
        $key = $mechEntity->getId();
        $this->chassisdefEntities[$key] = $mechEntity;
        $this->isSorted = false;
    }

    /**
     * @return ChassisdefEntity[]
     */
    public function get()
    {
        if (!$this->isSorted) {
            $this->sort();
        }

        return $this->chassisdefEntities;
    }

    /**
     * @param ChassisdefEntity[] $chasisDefEntities
     *
     * @return ChassisdefCollection
     */
    public static function fromArray(array $chasisDefEntities)
    {
        $collection = new self();

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
