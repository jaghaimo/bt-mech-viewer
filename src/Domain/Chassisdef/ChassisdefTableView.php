<?php

namespace Btmv\Domain\Chassisdef;

use Symfony\Component\Console\Helper\Table;

class ChassisdefTableView extends Table
{
    /**
     * @param ChassisdefCollection $chassisdefCollection
     */
    public function setChassisdefs(ChassisdefCollection $chassisdefCollection)
    {
        $this->setHeaders(
            ['Class', 'Tonnage', 'Name', 'Variant', 'Tags', 'Cost', 'B', 'E', 'M', 'S', 'Bundle']
        );
        $chassisdefEntities = $chassisdefCollection->get();
        $allCount = count($chassisdefEntities);
        $mechText = $allCount === 1 ? 'chassisdef' : 'chassisdefs';

        foreach ($chassisdefEntities as $chassisdefEntity) {
            $this->addRow([
                $chassisdefEntity->getClass(),
                $chassisdefEntity->getTonnage(),
                $chassisdefEntity->getName(),
                $chassisdefEntity->getVariant(),
                $chassisdefEntity->getTags()->getShortTags(),
                number_format($chassisdefEntity->getCost()),
                $this->getTotalHardpoints($chassisdefEntity, ChassisdefHardpoints::HARDPOINT_BALLISTIC),
                $this->getTotalHardpoints($chassisdefEntity, ChassisdefHardpoints::HARDPOINT_ENERGY),
                $this->getTotalHardpoints($chassisdefEntity, ChassisdefHardpoints::HARDPOINT_MISSILE),
                $this->getTotalHardpoints($chassisdefEntity, ChassisdefHardpoints::HARDPOINT_ANTI_PERSONNEL),
                $chassisdefEntity->getBundle()
            ]);
        }

        $this->setFooterTitle("Found $allCount $mechText matching your query");
    }

    /**
     * @param ChassisdefEntity $mech
     * @param string $hardpointType
     *
     * @return int
     */
    private function getTotalHardpoints(ChassisdefEntity $mech, string $hardpointType): int
    {
        $hardpoints = $mech->getLocations()->getTotalHardpoints($hardpointType);

        return $hardpoints < 0 ? 22 : $hardpoints;
    }
}
