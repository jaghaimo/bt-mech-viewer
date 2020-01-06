<?php

declare(strict_types=1);

namespace Btmv\Action;

use Btmv\Domain\Config\ConfigService;
use Btmv\Domain\Localization\LocalizationService;
use Btmv\Domain\Mech\MechCollection;
use Btmv\Domain\Mech\MechFilter;
use Btmv\Domain\Mech\MechService;

final class MechListAction
{
    private ConfigService $configService;
    private LocalizationService $localizationService;
    private MechFilter $mechFilter;
    private MechService $mechService;

    public function __construct(
        MechFilter $mechFilter,
        MechService $mechService,
        LocalizationService $localizationService,
        ConfigService $configService
    ) {
        $this->mechFilter = $mechFilter;
        $this->mechService = $mechService;
        $this->localizationService = $localizationService;
        $this->configService = $configService;
    }

    public function handle(array $filters = []): MechCollection
    {
        $config = $this->configService->getConfig();
        $modsDirectory = $config->getIncludeDirectories();
        $excludeDirs = $config->getExcludeDirectories();
        $this->populateFilters($filters);
        $localizationManager = $this->localizationService->getLocalizationManager($modsDirectory, $excludeDirs);

        return $this->mechService->findMechs(
            $modsDirectory,
            $excludeDirs,
            $this->mechFilter,
            $localizationManager
        );
    }

    private function populateFilters(array $filters): void
    {
        $this->mechFilter->setClass($filters['class']);
        $this->mechFilter->setTonnage($filters['tonnage']);
    }
}
