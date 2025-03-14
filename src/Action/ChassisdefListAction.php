<?php

declare(strict_types=1);

namespace Btmv\Action;

use Btmv\Domain\Chassisdef\ChassisdefCollection;
use Btmv\Domain\Chassisdef\ChassisdefFilter;
use Btmv\Domain\Chassisdef\ChassisdefService;
use Btmv\Domain\Config\ConfigService;
use Btmv\Domain\Localization\LocalizationService;

final class ChassisdefListAction
{
    private ChassisdefFilter $chassisdefFilter;
    private ChassisdefService $chassisdefService;
    private ConfigService $configService;
    private LocalizationService $localizationService;

    public function __construct(
        ChassisdefFilter $chassisdefFilter,
        ChassisdefService $chassisdefService,
        LocalizationService $localizationService,
        ConfigService $configService
    ) {
        $this->chassisdefFilter = $chassisdefFilter;
        $this->chassisdefService = $chassisdefService;
        $this->localizationService = $localizationService;
        $this->configService = $configService;
    }

    public function handle(string $filename, array $filters = []): ChassisdefCollection
    {
        $config = $this->configService->getConfig();
        $modsDirectory = $config->getIncludeDirectories();
        $excludeDirs = $config->getExcludeDirectories();
        $this->populateFilters($filters);
        $localizationManager = $this->localizationService->getLocalizationManager($modsDirectory, $excludeDirs);

        return $this->chassisdefService->findChassisdefs(
            $modsDirectory,
            $excludeDirs,
            $filename,
            $localizationManager,
            $this->chassisdefFilter
        );
    }

    private function populateFilters(array $filters): void
    {
        $this->chassisdefFilter->setBundle($filters['bundle']);
        $this->chassisdefFilter->setClass($filters['class']);
        $this->chassisdefFilter->setTonnage((int) $filters['tonnage']);
    }
}
