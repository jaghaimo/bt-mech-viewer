<?php

declare(strict_types=1);

namespace Btmv\Domain\Chassisdef;

use Btmv\Domain\Localization\LocalizationManager;
use Btmv\Utils\Finder\FinderHelper;

final class ChassisdefService
{
    const CHASSISDEF_PATTERN = '/^chassisdef\_%s\.json$/i';

    private ChassisdefReader $chassisdefReader;
    private FinderHelper $finderHelper;

    public function __construct(
        FinderHelper $finderHelper,
        ChassisdefReader $chassisdefReader
    ) {
        $this->finderHelper = $finderHelper;
        $this->chassisdefReader = $chassisdefReader;
    }

    /**
     * @param string[] $includeDirs
     * @param string[] $excludeDirs
     */
    public function findChassisdefs(
        array $includeDirs,
        array $excludeDirs,
        string $filename,
        LocalizationManager $localizationManager,
        ?ChassisdefFilter $chassisdefFilter
    ): ChassisdefCollection {
        $chassisdefCollection = new ChassisdefCollection();

        $name = sprintf(self::CHASSISDEF_PATTERN, $filename);
        $finder = $this->finderHelper->configure($includeDirs, $excludeDirs, $name);

        foreach ($finder->getIterator() as $fileInfo) {
            $chassisdef = $this->chassisdefReader->get($fileInfo);
            $oldName = $chassisdef->getName();
            $newName = $localizationManager->get($oldName);
            $chassisdef->setName($newName);
            $chassisdefCollection->add($chassisdef, $chassisdefFilter);
        }

        return $chassisdefCollection;
    }
}
