<?php

namespace Btmv\Command;

use Btmv\Action\ChassisdefListAction;
use Btmv\Command\Table\ChassisdefTableView;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ChassisdefListCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'chassisdef:list';

    private $chassisdefListAction;

    /**
     * @param ChassisdefListAction $chassisdefListAction
     */
    public function __construct(ChassisdefListAction $chassisdefListAction)
    {
        parent::__construct();
        $this->chassisdefListAction = $chassisdefListAction;
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
        $filename = $input->getOption('filename');
        $chassisdefs = $this->chassisdefListAction->execute($filename);

        $table = new ChassisdefTableView($output);
        $table->setChassisdefs($chassisdefs);
        $table->render();

        return 0;
    }
}
