<?php

namespace Btmv\Domain\Mech;

use Btmv\Domain\Config\ConfigEntity;
use Btmv\Domain\Config\ConfigService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;

abstract class MechCommand extends Command
{
    /**
     * @var MechService
     */
    protected $mechService;

    /**
     * @var ConfigService
     */
    private $configService;

    /**
     * @param ConfigService $configService
     * @param MechService $mechService
     */
    public function __construct(ConfigService $configService, MechService $mechService)
    {
        $this->configService = $configService;
        $this->mechService = $mechService;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->addOption('filename', null, InputOption::VALUE_OPTIONAL, 'Limit output to given mech files (default: *)', '*');
    }

    /**
     * @return ConfigEntity
     */
    protected function getConfig(): ConfigEntity
    {
        return $this->configService->getConfig();
    }
}
