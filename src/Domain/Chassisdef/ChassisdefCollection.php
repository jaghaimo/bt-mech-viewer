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
        $key = $this->getKey($mechEntity);
        $this->chassisdefEntities[$key] = $mechEntity;
        $this->isSorted = false;
    }

    /**
     * @return ChassisdefEntity[]
     */
    public function get()
    {
        if (!$this->isSorted) {
            ksort($this->chassisdefEntities, SORT_NATURAL);
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

    /**
     * @param ChassisdefEntity $chassisdefEntity
     *
     * @return string
     */
    private function getKey(ChassisdefEntity $chassisdefEntity): string
    {
        // todo: use filename for key and implement arbitrary sorting
        return sprintf(
            '%d:%s:%s',
            $chassisdefEntity->getTonnage(),
            $chassisdefEntity->getName(),
            $chassisdefEntity->getVariant()
        );
    }
}
