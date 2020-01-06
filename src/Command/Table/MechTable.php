<?php

declare(strict_types=1);

namespace Btmv\Command\Table;

use Btmv\Domain\Chassisdef\ChassisdefHardpoints;
use Btmv\Domain\Mech\MechCollection;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;

final class MechTable extends Table
{
    const ENTITES = 'mech';

    /**
     * @var FilterAwareCollectionFooter
     */
    private $footerProvider;

    public function __construct(ConsoleOutput $output, FilterAwareCollectionFooter $footerProvider)
    {
        parent::__construct($output);
        $this->footerProvider = $footerProvider;
    }

    public function setMechs(MechCollection $mechCollection): void
    {
        $this->setHeaders(
            ['Class', 'Tonnage', 'Name', 'Variant', 'Tags', 'Cost', 'B', 'E', 'M', 'S', 'Bundle']
        );
        $mechEntities = $mechCollection->getAll();

        foreach ($mechEntities as $mechEntity) {
            $chassisdefEntity = $mechEntity->getChassisdefEntity();
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

        $footer = $this->footerProvider->getFooter($mechCollection, self::ENTITES);
        $this->setFooterTitle($footer);
    }
}
