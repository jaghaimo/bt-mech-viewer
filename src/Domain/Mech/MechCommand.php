<?php

namespace Btmv\Domain\Mech;

use Btmv\Domain\Config\ConfigEntity;
use Btmv\Domain\Config\ConfigService;
use Symfony\Component\Console\Command\Command;

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

    /**
     * @return ConfigEntity
     */
    protected function getConfig(): ConfigEntity
    {
        return $this->configService->getConfig();
    }
}
