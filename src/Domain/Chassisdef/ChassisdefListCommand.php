<?php

namespace Btmv\Domain\Chassisdef;

use Btmv\Domain\Config\ConfigService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ChassisdefListCommand extends Command
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
     * @var string
     */
    protected static $defaultName = 'chassisdef:list';

    /**
     * @param ConfigService $configService
     * @param ChassisdefService $chassisdefService
     */
    public function __construct(ConfigService $configService, ChassisdefService $chassisdefService)
    {
        parent::__construct();
        $this->configService = $configService;
        $this->chassisdefService = $chassisdefService;
    }

    protected function configure()
    {
        parent::configure();
        $this
            ->setDescription('List chassisdefs defined in the configured folder.')
            ->addOption('filename', null, InputOption::VALUE_OPTIONAL, 'Limit output to given chassisdef files (default: *)', '*');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $config = $this->configService->getConfig();
        $modsDirectory = $config->getIncludeDirectories();
        $excludeDirs = $config->getExcludeDirectories();
        $filename = $input->getOption('filename');
        $filter = $this->getFilter($input);
        $chassisdefs = $this->chassisdefService->findChassisdefs($modsDirectory, $excludeDirs, $filename, $filter);

        $table = new ChassisdefTableView($output);
        $table->setChassisdefs($chassisdefs);
        $table->render();

        return 0;
    }

    /**
     * @param InputInterface $input
     *
     * @return ChassisdefFilter
     */
    private function getFilter(InputInterface $input): ChassisdefFilter
    {
        return new ChassisdefFilter();
    }
}
