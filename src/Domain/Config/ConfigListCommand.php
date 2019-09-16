<?php

namespace Btmv\Domain\Config;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConfigListCommand extends ConfigCommand
{
    /**
     * @var string
     */
    protected static $defaultName = 'config:list';

    protected function configure()
    {
        $this
            ->setDescription('List current config values.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $configEntity = $this->configService->getConfig();

        // TODO: Make ConfigTableView and use here
        $output->writeln('modsDirectory: ' . $configEntity->getModsDirectory());

        return 0;
    }
}
