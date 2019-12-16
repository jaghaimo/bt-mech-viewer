<?php

declare(strict_types=1);

namespace Btmv\Domain\Localization;

use Btmv\Utils\Finder\FinderHelper;

final class LocalizationService
{
    const LOCALIZATION_PATTERN = '/^Localization.json$/i';

    /**
     * @var FinderHelper
     */
    private $finderHelper;

    /**
     * @var LocalizationReader
     */
    private $localizationReader;

    public function __construct(FinderHelper $finderHelper, LocalizationReader $localizationReader)
    {
        $this->finderHelper = $finderHelper;
        $this->localizationReader = $localizationReader;
    }

    /**
     * @param string[] $includeDirs
     * @param string[] $excludeDirs
     */
    public function getLocalizationManager(array $includeDirs, array $excludeDirs, string $filename): LocalizationManager
    {
        $localizationManager = new LocalizationManager();
        $finder = $this->finderHelper->configure($includeDirs, $excludeDirs, self::LOCALIZATION_PATTERN);

        foreach ($finder->getIterator() as $fileInfo) {
            $localizations = $this->localizationReader->get($fileInfo);
            $localizationManager->add($localizations);
        }

        return $localizationManager;
    }
}
