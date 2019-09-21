<?php

namespace Btmv\Domain\Mech;

class MechCollection
{
    /**
     * @var bool
     */
    private $isSorted = false;

    /**
     * @var MechEntity[]
     */
    private $mechs = [];

    /**
     * @param MechEntity $mechEntity
     */
    public function add(MechEntity $mechEntity)
    {
        $key = $this->getKey($mechEntity);
        $this->mechs[$key] = $mechEntity;
        $this->isSorted = false;
    }

    /**
     * @return MechEntity[]
     */
    public function getMechs()
    {
        if (!$this->isSorted) {
            ksort($this->mechs, SORT_NATURAL);
        }

        return $this->mechs;
    }

    /**
     * @param MechEntity[] $mechs
     *
     * @return MechCollection
     */
    public static function fromArray(array $mechs)
    {
        $collection = new self();

        foreach ($mechs as $mech) {
            if ($mech instanceof MechEntity) {
                $collection->add($mech);
            }
        }

        return $collection;
    }

    /**
     * @param MechEntity $mechEntity
     *
     * @return string
     */
    private function getKey(MechEntity $mechEntity): string
    {
        return sprintf('%d:%s:%s', $mechEntity->getTonnage(), $mechEntity->getName(), $mechEntity->getVariant());
    }
}
