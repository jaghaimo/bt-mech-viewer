<?php

declare(strict_types=1);

namespace Btmv\Domain\Localization;

use Btmv\Utils\Json\JsonHelper;
use Symfony\Component\Finder\SplFileInfo;

final class LocalizationReader
{
    /**
     * @var JsonHelper
     */
    private $jsonHelper;

    public function __construct(JsonHelper $jsonHelper)
    {
        $this->jsonHelper = $jsonHelper;
    }

    /**
     * @return array<string,string>
     */
    public function get(SplFileInfo $fileInfo): array
    {
        $localizationPath = $fileInfo->getRealPath();
        $localizations = [];
        $rawLocalizations = $this->jsonHelper->read($localizationPath);

        foreach ($rawLocalizations as $localization) {
            $key = $localization['Name'];
            $value = $localization['Localization']['CULTURE_EN_US'] ?? null;

            if (null !== $value) {
                $localizations[$key] = $value;
            }
        }

        return $localizations;
    }
}
