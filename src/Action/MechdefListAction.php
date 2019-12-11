<?php

declare(strict_types=1);

namespace Btmv\Action;

use Btmv\Domain\Config\ConfigService;
use Btmv\Domain\Mechdef\MechdefCollection;
use Btmv\Domain\Mechdef\MechdefFilter;
use Btmv\Domain\Mechdef\MechdefService;

final class MechdefListAction
{
    /**
     * @var ConfigService
     */
    private $configService;

    /**
     * @var MechdefFilter
     */
    private $mechdefFilter;

    /**
     * @var MechdefService
     */
    private $mechdefService;

    public function __construct(
        MechdefFilter $mechdefFilter,
        MechdefService $mechdefService,
        ConfigService $configService
    ) {
        $this->mechdefFilter = $mechdefFilter;
        $this->mechdefService = $mechdefService;
        $this->configService = $configService;
    }

    public function handle(string $filename, array $filters = []): MechdefCollection
    {
        $config = $this->configService->getConfig();
        $modsDirectory = $config->getIncludeDirectories();
        $excludeDirs = $config->getExcludeDirectories();
        $this->populateFilters($filters);

        return $this->mechdefService->findMechdefs(
            $modsDirectory,
            $excludeDirs,
            $filename,
            $this->mechdefFilter
        );
    }

    private function populateFilters(array $filters): void
    {
        $this->mechdefFilter->setBundle($filters['bundle']);
    }
}
