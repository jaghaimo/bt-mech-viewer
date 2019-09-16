<?php

namespace Btmv\Domain\Config;

use Symfony\Component\Console\Command\Command;

abstract class ConfigCommand extends Command
{
    /**
     * @var ConfigService
     */
    protected $configService;

    /**
     * @param ConfigService $configService
     */
    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
        parent::__construct();
    }
}
