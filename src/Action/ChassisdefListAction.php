<?php


namespace Btmv\Action;


use Btmv\Domain\Chassisdef\ChassisdefCollection;
use Btmv\Domain\Chassisdef\ChassisdefFilter;
use Btmv\Domain\Chassisdef\ChassisdefService;
use Btmv\Domain\Config\ConfigService;

class ChassisdefListAction
{
    /**
     * @var ChassisdefService
     */
    private $chassisdefService;

    /**
     * @var ConfigService
     */
    private $configService;

    /**
     * @param ChassisdefService $chassisdefService
     * @param ConfigService $configService
     */
    public function __construct(ChassisdefService $chassisdefService, ConfigService $configService)
    {
        $this->chassisdefService = $chassisdefService;
        $this->configService = $configService;
    }

    /**
     * @param string $filename
     *
     * @return ChassisdefCollection
     */
    public function execute(string $filename): ChassisdefCollection
    {
        $config = $this->configService->getConfig();
        $excludeDirs = $config->getExcludeDirectories();
        $modsDirectory = $config->getIncludeDirectories();
        $filter = $this->getFilter();

        return $this->chassisdefService->findChassisdefs($modsDirectory, $excludeDirs, $filename, $filter);
    }

    /**
     * @return ChassisdefFilter
     */
    private function getFilter(): ChassisdefFilter
    {
        return new ChassisdefFilter();
    }
}
