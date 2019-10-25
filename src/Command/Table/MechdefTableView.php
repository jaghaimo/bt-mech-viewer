<?php

declare(strict_types=1);

namespace Btmv\Command\Table;

use Btmv\Domain\Mechdef\MechdefCollection;
use Symfony\Component\Console\Helper\Table;

final class MechdefTableView extends Table
{
    /**
     * @param MechdefCollection $mechdefCollection
     */
    public function setMechdefs(MechdefCollection $mechdefCollection): void
    {
        $this->setHeaders(
            ['Name', 'MechID', 'ChassisID', 'Bundle']
        );
        $mechdefEntities = $mechdefCollection->getAll();

        foreach ($mechdefEntities as $mechdefEntity) {
            $this->addRow([
                $mechdefEntity->getName(),
                $mechdefEntity->getId(),
                $mechdefEntity->getChassisId(),
                $mechdefEntity->getBundle(),
            ]);
        }

        $this->setFooter($mechdefCollection);
    }

    /**
     * @param MechdefCollection $mechdefCollection
     */
    private function setFooter(MechdefCollection $mechdefCollection): void
    {
        $totalCount = $mechdefCollection->getTotalCount();
        $matchingCount = $mechdefCollection->getMatchingCount();
        $filteredCount = $totalCount - $matchingCount;

        $mechdefText = 1 === $matchingCount ? 'mechdef' : 'mechdefs';
        $footer = "Found {$matchingCount} {$mechdefText} matching your query";

        if ($filteredCount > 0) {
            $footer .= " ({$filteredCount} removed by filters)";
        }

        $this->setFooterTitle($footer);
    }
}
