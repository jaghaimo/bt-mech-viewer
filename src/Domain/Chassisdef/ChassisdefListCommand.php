<?php

namespace Btmv\Domain\Chassisdef;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ChassisdefListCommand extends ChassisdefCommand
{
    /**
     * @var string
     */
    protected static $defaultName = 'chassisdef:list';

    protected function configure()
    {
        parent::configure();

        $this
            ->setDescription('List chassisdefs defined in the configured folder.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $config = $this->getConfig();
        $modsDirectory = $config->getIncludeDirectories();
        $excludeDirs = $config->getExcludeDirectories();
        $filename = $input->getOption('filename');
        $chassisdefs = $this->chassisdefService->findChassisdefs($modsDirectory, $excludeDirs, $filename);

        $table = new ChassisdefTableView($output);
        $table->setChassisdefs($chassisdefs);
        $table->render();

        return 0;
    }
}
