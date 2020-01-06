<?php

declare(strict_types=1);

namespace Btmv\Action;

use Btmv\Domain\Config\ConfigService;
use Btmv\Domain\Localization\LocalizationService;
use Btmv\Domain\Mechdef\MechdefCollection;
use Btmv\Domain\Mechdef\MechdefFilter;
use Btmv\Domain\Mechdef\MechdefService;

final class MechdefListAction
{
    private ConfigService $configService;
    private LocalizationService $localizationService;
    private MechdefFilter $mechdefFilter;
    private MechdefService $mechdefService;

    public function __construct(
        MechdefFilter $mechdefFilter,
        MechdefService $mechdefService,
        LocalizationService $localizationService,
        ConfigService $configService
    ) {
        $this->mechdefFilter = $mechdefFilter;
        $this->mechdefService = $mechdefService;
        $this->localizationService = $localizationService;
        $this->configService = $configService;
    }

    public function handle(string $filename, array $filters = []): MechdefCollection
    {
        $config = $this->configService->getConfig();
        $modsDirectory = $config->getIncludeDirectories();
        $excludeDirs = $config->getExcludeDirectories();
        $this->populateFilters($filters);
        $localizationManager = $this->localizationService->getLocalizationManager($modsDirectory, $excludeDirs);

        return $this->mechdefService->findMechdefs(
            $modsDirectory,
            $excludeDirs,
            $filename,
            $localizationManager,
            $this->mechdefFilter
        );
    }

    private function populateFilters(array $filters): void
    {
        $this->mechdefFilter->setBundle($filters['bundle']);
    }
}
