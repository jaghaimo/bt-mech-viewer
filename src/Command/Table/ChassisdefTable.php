<?php

declare(strict_types=1);

namespace Btmv\Command\Table;

use Btmv\Domain\Chassisdef\ChassisdefCollection;
use Btmv\Domain\Chassisdef\ChassisdefHardpoints;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;

final class ChassisdefTable extends Table
{
    const ENTITES = 'chassisdef';

    /**
     * @var FilterAwareCollectionFooter
     */
    private $footerProvider;

    public function __construct(ConsoleOutput $output, FilterAwareCollectionFooter $footerProvider)
    {
        parent::__construct($output);
        $this->footerProvider = $footerProvider;
    }

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

        $footer = $this->footerProvider->getFooter($chassisdefCollection, self::ENTITES);
        $this->setFooterTitle($footer);
    }
}
