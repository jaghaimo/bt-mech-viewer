<?php

namespace Btmv\Domain\Chassisdef;

use Btmv\Domain\Config\ConfigEntity;
use Btmv\Domain\Config\ConfigService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;

abstract class ChassisdefCommand extends Command
{
    /**
     * @var ChassisdefService
     */
    protected $chassisdefService;

    /**
     * @var ConfigService
     */
    private $configService;

    /**
     * @param ConfigService $configService
     * @param ChassisdefService $chassisdefService
     */
    public function __construct(ConfigService $configService, ChassisdefService $chassisdefService)
    {
        $this->configService = $configService;
        $this->chassisdefService = $chassisdefService;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->addOption('filename', null, InputOption::VALUE_OPTIONAL, 'Limit output to given chassisdef files (default: *)', '*');
    }

    /**
     * @return ConfigEntity
     */
    protected function getConfig(): ConfigEntity
    {
        return $this->configService->getConfig();
    }
}
