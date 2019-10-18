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

    /**
     * @var ChassisdefListAction
     */
    private $chassisdefListAction;

    /**
     * @param ChassisdefListAction $chassisdefListAction
     */
    public function __construct(ChassisdefListAction $chassisdefListAction)
    {
        parent::__construct();
        $this->chassisdefListAction = $chassisdefListAction;
    }

    protected function configure(): void
    {
        parent::configure();
        $this
            ->setDescription('List chassisdefs defined in the configured folder.')
            ->addOption('filename', null, InputOption::VALUE_OPTIONAL, 'Limit output to given chassisdef files (default: *)', '*')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filename = $this->getFilename($input);
        $chassisdefs = $this->chassisdefListAction->execute($filename);

        $table = new ChassisdefTableView($output);
        $table->setChassisdefs($chassisdefs);
        $table->render();

        return 0;
    }

    /**
     * @param InputInterface $input
     *
     * @return string
     */
    private function getFilename(InputInterface $input): string
    {
        $filename = $input->getOption('filename');

        if (is_array($filename)) {
            $filename = $filename[0];
        }

        return (string) $filename;
    }
}
