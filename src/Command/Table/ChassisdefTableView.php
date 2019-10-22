<?php

declare(strict_types=1);

namespace Btmv\Command\Table;

use Btmv\Domain\Chassisdef\ChassisdefCollection;
use Btmv\Domain\Chassisdef\ChassisdefHardpoints;
use Symfony\Component\Console\Helper\Table;

final class ChassisdefTableView extends Table
{
    /**
     * @param ChassisdefCollection $chassisdefCollection
     */
    public function setChassisdefs(ChassisdefCollection $chassisdefCollection): void
    {
        $this->setHeaders(
            ['Class', 'Tonnage', 'Name', 'Variant', 'Tags', 'Cost', 'B', 'E', 'M', 'S', 'Bundle']
        );
        $chassisdefEntities = $chassisdefCollection->getAll();

        foreach ($chassisdefEntities as $chassisdefEntity) {
            $this->addRow([
                $chassisdefEntity->getClass(),
                $chassisdefEntity->getTonnage(),
                $chassisdefEntity->getName(),
                $chassisdefEntity->getVariant(),
                $chassisdefEntity->getTags()->getShortTags(),
                number_format($chassisdefEntity->getCost()),
                $chassisdefEntity->getLocations()->getTotalHardpoints(ChassisdefHardpoints::HARDPOINT_BALLISTIC),
                $chassisdefEntity->getLocations()->getTotalHardpoints(ChassisdefHardpoints::HARDPOINT_ENERGY),
                $chassisdefEntity->getLocations()->getTotalHardpoints(ChassisdefHardpoints::HARDPOINT_MISSILE),
                $chassisdefEntity->getLocations()->getTotalHardpoints(ChassisdefHardpoints::HARDPOINT_ANTI_PERSONNEL),
                $chassisdefEntity->getBundle(),
            ]);
        }

        $this->setFooter($chassisdefCollection);
    }

    /**
     * @param ChassisdefCollection $chassisdefCollection
     */
    private function setFooter(ChassisdefCollection $chassisdefCollection): void
    {
        $totalCount = $chassisdefCollection->getTotalCount();
        $matchingCount = $chassisdefCollection->getMatchingCount();
        $filteredCount = $totalCount - $matchingCount;

        $chassisdefText = 1 === $matchingCount ? 'chassisdef' : 'chassisdefs';
        $footer = "Found {$matchingCount} {$chassisdefText} matching your query";

        if ($filteredCount > 0) {
            $footer .= " ({$filteredCount} removed by filters)";
        }

        $this->setFooterTitle($footer);
    }
}
