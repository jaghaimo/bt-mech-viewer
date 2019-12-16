<?php

declare(strict_types=1);

namespace Btmv\Domain\Chassisdef;

use Btmv\Domain\Localization\LocalizationService;
use Btmv\Utils\Finder\FinderHelper;

final class ChassisdefService
{
    const CHASSISDEF_PATTERN = '/^chassisdef\_%s\.json$/i';

    /**
     * @var ChassisdefReader
     */
    private $chassisdefReader;

    /**
     * @var FinderHelper
     */
    private $finderHelper;

    /**
     * @var LocalizationService
     */
    private $localizationService;

    public function __construct(
        FinderHelper $finderHelper,
        ChassisdefReader $chassisdefReader,
        LocalizationService $localizationService
    ) {
        $this->finderHelper = $finderHelper;
        $this->chassisdefReader = $chassisdefReader;
        $this->localizationService = $localizationService;
    }

    /**
     * @param string[] $includeDirs
     * @param string[] $excludeDirs
     */
    public function findChassisdefs(
        array $includeDirs,
        array $excludeDirs,
        string $filename,
        ChassisdefFilter $chassisdefFilter
    ): ChassisdefCollection {
        $chassisdefCollection = new ChassisdefCollection();
        $localizationManager = $this->localizationService->getLocalizationManager($includeDirs, $excludeDirs, $filename);

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
