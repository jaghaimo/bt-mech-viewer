<?php

declare(strict_types=1);

namespace Btmv\Command;

use Btmv\Action\MechdefListAction;
use Btmv\Command\Table\MechdefTable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class MechdefListCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'mechdef:list';

    /**
     * @var MechdefListAction
     */
    private $mechdefListAction;

    /**
     * @var MechdefTable
     */
    private $mechdefTable;

    public function __construct(MechdefListAction $mechdefListAction, MechdefTable $mechdefTable)
    {
        parent::__construct();
        $this->mechdefListAction = $mechdefListAction;
        $this->mechdefTable = $mechdefTable;
    }

    protected function configure(): void
    {
        parent::configure();
        $this
            ->setDescription('List mechdefs defined in the configured folder.')
            ->addOption('filename', null, InputOption::VALUE_OPTIONAL, 'Limit output to given mechdef files', '*')
            ->addOption('bundle', null, InputOption::VALUE_OPTIONAL, 'Filter output based on bundle (string)')
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
        $filename = (string) $this->getInputValue($input, 'filename');
        $filters = $this->getFilters($input);

        $mechdefs = $this->mechdefListAction->handle($filename, $filters);

        $this->mechdefTable->setMechdefs($mechdefs);
        $this->mechdefTable->render();

        return 0;
    }

    /**
     * @param InputInterface $input
     *
     * @return array
     */
    private function getFilters(InputInterface $input): array
    {
        return [
            'bundle' => $this->getInputValue($input, 'bundle'),
        ];
    }

    /**
     * @param InputInterface $input
     * @param string         $option
     *
     * @return null|string
     */
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
