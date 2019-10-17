<?php

namespace Btmv\Domain\Chassisdef;

class ChassisdefFilter
{
    /**
     * @param ChassisdefEntity $chassisdefEntity
     *
     * @return bool
     */
    public function isMatching(ChassisdefEntity $chassisdefEntity)
    {
        return true;
    }
}
