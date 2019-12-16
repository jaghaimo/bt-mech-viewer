<?php

declare(strict_types=1);

namespace Btmv\Command;

use Btmv\Action\ChassisdefListAction;
use Btmv\Command\Table\ChassisdefTable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class ChassisdefListCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'def:chassis:list';

    /**
     * @var ChassisdefListAction
     */
    private $chassisdefListAction;

    /**
     * @var ChassisdefTable
     */
    private $chassisdefTable;

    public function __construct(ChassisdefListAction $chassisdefListAction, ChassisdefTable $chassisdefTable)
    {
        parent::__construct();
        $this->chassisdefListAction = $chassisdefListAction;
        $this->chassisdefTable = $chassisdefTable;
    }

    protected function configure(): void
    {
        parent::configure();
        $this
            ->setHidden(true)
            ->setDescription('List chassisdefs defined in the configured folder.')
            ->addOption('filename', null, InputOption::VALUE_OPTIONAL, 'Limit output to given chassisdef files', '*')
            ->addOption('bundle', null, InputOption::VALUE_OPTIONAL, 'Filter output based on bundle (string)')
            ->addOption('class', null, InputOption::VALUE_OPTIONAL, 'Filter output based on class (string)')
            ->addOption('tonnage', null, InputOption::VALUE_OPTIONAL, 'Filter output based on tonnage (integer)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filename = (string) $this->getInputValue($input, 'filename');
        $filters = $this->getFilters($input);

        $chassisdefs = $this->chassisdefListAction->handle($filename, $filters);

        $this->chassisdefTable->setChassisdefs($chassisdefs);
        $this->chassisdefTable->render();

        return 0;
    }

    private function getFilters(InputInterface $input): array
    {
        return [
            'bundle' => $this->getInputValue($input, 'bundle'),
            'class' => $this->getInputValue($input, 'class'),
            'tonnage' => $this->getInputValue($input, 'tonnage'),
        ];
    }

    private function getInputValue(InputInterface $input, string $option): ?string
    {
        $value = $input->getOption($option);

        if (is_array($value)) {
            $value = $value[0];
        }

        if (is_null($value)) {
            return null;
        }

        return (string) $value;
    }
}
