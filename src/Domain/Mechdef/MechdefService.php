<?php

declare(strict_types=1);

namespace Btmv\Domain\Mechdef;

use Btmv\Domain\Localization\LocalizationManager;
use Btmv\Utils\Finder\FinderHelper;

final class MechdefService
{
    const MECHDEF_PATTERN = '/^mechdef\_%s\.json$/i';

    private FinderHelper $finderHelper;
    private MechdefReader $mechdefReader;

    public function __construct(
        FinderHelper $finderHelper,
        MechdefReader $mechdefReader
    ) {
        $this->finderHelper = $finderHelper;
        $this->mechdefReader = $mechdefReader;
    }

    /**
     * @param string[] $includeDirs
     * @param string[] $excludeDirs
     */
    public function findMechdefs(
        array $includeDirs,
        array $excludeDirs,
        string $filename,
        LocalizationManager $localizationManager,
        ?MechdefFilter $mechdefFilter
    ): MechdefCollection {
        $mechdefCollection = new MechdefCollection();

        $name = sprintf(self::MECHDEF_PATTERN, $filename);
        $finder = $this->finderHelper->configure($includeDirs, $excludeDirs, $name);

        foreach ($finder->getIterator() as $fileInfo) {
            $mechdef = $this->mechdefReader->get($fileInfo);
            $oldName = $mechdef->getName();
            $newName = $localizationManager->get($oldName);
            $mechdef->setName($newName);
            $mechdefCollection->add($mechdef, $mechdefFilter);
        }

        return $mechdefCollection;
    }
}
