<?php

namespace Btmv\Domain\Mech;

use Symfony\Component\Console\Helper\Table;

class MechTableView extends Table
{
    /**
     * @param MechCollection $mechs
     */
    public function setMechs(MechCollection $mechs)
    {
        $this->setHeaders(['Class', 'Tonnage', 'Name', 'Variant', 'B', 'E', 'M', 'S', 'Bundle']);
        $allMechs = $mechs->getMechs();
        $allCount = count($allMechs);
        $mechText = $allCount === 1 ? 'mech' : 'mechs';

        foreach ($allMechs as $mech) {
            $this->addRow([
                $mech->getClass(),
                $mech->getTonnage(),
                $mech->getName(),
                $mech->getVariant(),
                $this->getTotalHardpoints($mech, MechHardpoints::HARDPOINT_BALLISTIC),
                $this->getTotalHardpoints($mech, MechHardpoints::HARDPOINT_ENERGY),
                $this->getTotalHardpoints($mech, MechHardpoints::HARDPOINT_MISSILE),
                $this->getTotalHardpoints($mech, MechHardpoints::HARDPOINT_ANTI_PERSONNEL),
                $mech->getBundle()
            ]);
        }

        $this->setFooterTitle("Found $allCount $mechText matching your query");
    }

    /**
     * @param MechEntity $mech
     * @param string $hardpointType
     *
     * @return int
     */
    private function getTotalHardpoints(MechEntity $mech, string $hardpointType): int
    {
        $hardpoints = $mech->getTotalHardpoints($hardpointType);

        return $hardpoints < 0 ? 12 : $hardpoints;
    }
}
