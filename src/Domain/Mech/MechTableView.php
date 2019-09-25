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
        $this->setHeaders(['Class', 'Tonnage', 'Name', 'Variant']);

        foreach ($mechs->getMechs() as $mech) {
            $this->addRow([
                $mech->getClass(),
                $mech->getTonnage(),
                $mech->getName(),
                $mech->getVariant()
            ]);
        }
    }
}
