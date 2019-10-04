<?php

namespace Btmv\Domain\Mech;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MechListCommand extends MechCommand
{
    /**
     * @var string
     */
    protected static $defaultName = 'mech:list';

    protected function configure()
    {
        parent::configure();

        $this
            ->setDescription('List mechs defined in the configured folder.');
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
        $mechs = $this->mechService->findMechs($modsDirectory, $excludeDirs, $filename);

        $table = new MechTableView($output);
        $table->setMechs($mechs);
        $table->render();

        return 0;
    }
}
