<?php

namespace Btmv\Domain\Config;

use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ConfigSetCommand extends ConfigCommand
{
    /**
     * @var string
     */
    protected static $defaultName = 'config:set';

    protected function configure()
    {
        $this
            ->setDescription('Sets a config value.')
            ->addOption('key', null, InputOption::VALUE_REQUIRED)
            ->addOption('value', null, InputOption::VALUE_REQUIRED);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $key = $input->getOption('key');
        $value = (string)$input->getOption('value');

        if (empty($key)) {
            throw new InvalidOptionException('Cannot use an empty key');
        }

        $output->writeln("Setting '$key' to '$value'");
        $oldValue = $this->configService->setConfig($key, $value);
        $output->writeln("Previous value was '$oldValue'");

        return 0;
    }
}
