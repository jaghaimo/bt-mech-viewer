<?php

namespace Btmv\Domain\Mech;

use Symfony\Component\Console\Helper\Table;
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
        $mechs = $this->mechService->findMechs($config->getModsDirectory());

        $table = new MechTableView($output);
        $table->setMechs($mechs);
        $table->render();

        return 0;
    }
}
