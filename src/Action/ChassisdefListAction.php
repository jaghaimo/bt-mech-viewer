<?php

declare(strict_types=1);

namespace Btmv\Action;

use Btmv\Domain\Chassisdef\ChassisdefCollection;
use Btmv\Domain\Chassisdef\ChassisdefFilter;
use Btmv\Domain\Chassisdef\ChassisdefService;
use Btmv\Domain\Config\ConfigService;

class ChassisdefListAction
{
    /**
     * @var ChassisdefFilter
     */
    private $chassisdefFilter;

    /**
     * @var ChassisdefService
     */
    private $chassisdefService;

    /**
     * @var ConfigService
     */
    private $configService;

    /**
     * @param ChassisdefFilter  $chassisdefFilter
     * @param ChassisdefService $chassisdefService
     * @param ConfigService     $configService
     */
    public function __construct(
        ChassisdefFilter $chassisdefFilter,
        ChassisdefService $chassisdefService,
        ConfigService $configService
    ) {
        $this->chassisdefFilter = $chassisdefFilter;
        $this->chassisdefService = $chassisdefService;
        $this->configService = $configService;
    }

    /**
     * @param string $filename
     * @param array  $filters
     *
     * @return ChassisdefCollection
     */
    public function execute(string $filename, array $filters = []): ChassisdefCollection
    {
        $config = $this->configService->getConfig();
        $modsDirectory = $config->getIncludeDirectories();
        $excludeDirs = $config->getExcludeDirectories();
        $this->populateFilters($filters);

        return $this->chassisdefService->findChassisdefs(
            $modsDirectory,
            $excludeDirs,
            $filename,
            $this->chassisdefFilter
        );
    }

    /**
     * @param array $filters
     */
    private function populateFilters(array $filters): void
    {
        $this->chassisdefFilter->setBundle($filters['bundle']);
        $this->chassisdefFilter->setClass($filters['class']);
        $this->chassisdefFilter->setTonnage((int) $filters['tonnage']);
    }
}
