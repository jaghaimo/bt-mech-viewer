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
        $this->setHeaders(['Class', 'Tonnage', 'Name', 'Variant', 'B', 'E', 'M', 'S']);

        foreach ($mechs->getMechs() as $mech) {
            $this->addRow([
                $mech->getClass(),
                $mech->getTonnage(),
                $mech->getName(),
                $mech->getVariant(),
                $this->getTotalHardpoints($mech, MechHardpoints::HARDPOINT_BALLISTIC),
                $this->getTotalHardpoints($mech, MechHardpoints::HARDPOINT_ENERGY),
                $this->getTotalHardpoints($mech, MechHardpoints::HARDPOINT_MISSILE),
                $this->getTotalHardpoints($mech, MechHardpoints::HARDPOINT_ANTI_PERSONNEL)
            ]);
        }
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
