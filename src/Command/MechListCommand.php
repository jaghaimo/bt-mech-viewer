<?php

declare(strict_types=1);

namespace Btmv\Command;

use Btmv\Action\MechListAction;
use Btmv\Command\Table\MechTable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class MechListCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'mech:list';

    private MechListAction $mechListAction;

    private MechTable $mechTable;

    public function __construct(MechListAction $mechListAction, MechTable $mechTable)
    {
        parent::__construct();
        $this->mechListAction = $mechListAction;
        $this->mechTable = $mechTable;
    }

    protected function configure(): void
    {
        parent::configure();
        $this
            ->setDescription('List mechs defined in the configured folder.')
            ->addOption('class', null, InputOption::VALUE_OPTIONAL, 'Filter output based on class (string)')
            ->addOption('tonnage', null, InputOption::VALUE_OPTIONAL, 'Filter output based on tonnage (integer)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filters = $this->getFilters($input);

        $mechs = $this->mechListAction->handle($filters);

        $this->mechTable->setMechs($mechs);
        $this->mechTable->render();

        return 0;
    }

    private function getFilters(InputInterface $input): array
    {
        return [
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
