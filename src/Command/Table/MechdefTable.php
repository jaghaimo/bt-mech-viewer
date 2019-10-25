<?php

declare(strict_types=1);

namespace Btmv\Command\Table;

use Btmv\Domain\Mechdef\MechdefCollection;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;

final class MechdefTable extends Table
{
    const ENTITES = 'mechdef';

    /**
     * @var FilterAwareCollectionFooter
     */
    private $footerProvider;

    public function __construct(ConsoleOutput $output, FilterAwareCollectionFooter $footerProvider)
    {
        parent::__construct($output);
        $this->footerProvider = $footerProvider;
    }

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

        $footer = $this->footerProvider->getFooter($mechdefCollection, self::ENTITES);
        $this->setFooterTitle($footer);
    }
}
