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
                $mech->getTotalHardpoints(MechHardpoints::HARDPOINT_BALLISTIC),
                $mech->getTotalHardpoints(MechHardpoints::HARDPOINT_ENERGY),
                $mech->getTotalHardpoints(MechHardpoints::HARDPOINT_MISSILE),
                $mech->getTotalHardpoints(MechHardpoints::HARDPOINT_ANTI_PERSONNEL)
            ]);
        }
    }
}
