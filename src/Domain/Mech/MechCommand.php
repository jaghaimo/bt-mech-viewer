<?php

namespace Btmv\Domain\Mech;

use Btmv\Domain\Config\ConfigEntity;
use Btmv\Domain\Config\ConfigService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

abstract class MechCommand extends Command
{
    /**
     * @var ConfigService
     */
    private $configService;

    /**
     * @var MechService
     */
    protected $mechService;

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
            ->addOption('name', null, InputOption::VALUE_OPTIONAL, 'Limit output to given mech name', '*')
            ->addOption('variant', null, InputOption::VALUE_OPTIONAL, 'Limit output to given mech variant', '*');
    }

    /**
     * @return ConfigEntity
     */
    protected function getConfig(): ConfigEntity
    {
        return $this->configService->getConfig();
    }
}
