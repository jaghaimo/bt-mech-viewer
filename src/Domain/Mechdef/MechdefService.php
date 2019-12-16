<?php

declare(strict_types=1);

namespace Btmv\Domain\Mechdef;

use Btmv\Domain\Localization\LocalizationService;
use Btmv\Utils\Finder\FinderHelper;

final class MechdefService
{
    const MECHDEF_PATTERN = '/^mechdef\_%s\.json$/i';

    /**
     * @var FinderHelper
     */
    private $finderHelper;

    /**
     * LocalizationService.
     */
    private $localizationService;

    /**
     * @var MechdefReader
     */
    private $mechdefReader;

    public function __construct(
        FinderHelper $finderHelper,
        LocalizationService $localizationService,
        MechdefReader $mechdefReader
    ) {
        $this->finderHelper = $finderHelper;
        $this->localizationService = $localizationService;
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
        MechdefFilter $mechdefFilter
    ): MechdefCollection {
        $mechdefCollection = new MechdefCollection();
        $localizationManager = $this->localizationService->getLocalizationManager($includeDirs, $excludeDirs, $filename);

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
