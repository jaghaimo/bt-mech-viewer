<?php

declare(strict_types=1);

namespace Btmv\Domain\Mech;

use Btmv\Domain\Chassisdef\ChassisdefService;
use Btmv\Domain\Localization\LocalizationManager;
use Btmv\Domain\Mechdef\MechdefService;
use Btmv\Utils\Finder\FinderHelper;

final class MechService
{
    const CHASSISDEF_FILTER = null;
    const FILES_ALL = '*';
    const MECHDEF_FILTER = null;
    const NO_SORTING = false;

    private ChassisdefService $chassisdefService;
    private FinderHelper $finderHelper;
    private MechdefService $mechdefService;

    public function __construct(
        ChassisdefService $chassisdefService,
        FinderHelper $finderHelper,
        MechdefService $mechdefService
    ) {
        $this->chassisdefService = $chassisdefService;
        $this->finderHelper = $finderHelper;
        $this->mechdefService = $mechdefService;
    }

    /**
     * @param string[] $includeDirs
     * @param string[] $excludeDirs
     */
    public function findMechs(
        array $includeDirs,
        array $excludeDirs,
        MechFilter $mechFilter,
        LocalizationManager $localizationManager
    ): MechCollection {
        $chassisdefCollection = $this->chassisdefService->findChassisdefs(
            $includeDirs,
            $excludeDirs,
            self::FILES_ALL,
            $localizationManager,
            self::CHASSISDEF_FILTER
        );

        $mechdefCollection = $this->mechdefService->findMechdefs(
            $includeDirs,
            $excludeDirs,
            self::FILES_ALL,
            $localizationManager,
            self::MECHDEF_FILTER
        );

        $mechCollection = new MechCollection();

        foreach ($mechdefCollection->getAll(self::NO_SORTING) as $mechdefEntity) {
            $chassisId = $mechdefEntity->getChassisId();
            $chassisdefEntity = $chassisdefCollection->get($chassisId);

            if (is_null($chassisdefEntity)) {
                // TODO: log this
                continue;
            }

            $mechEntity = new MechEntity($chassisdefEntity, $mechdefEntity);
            $mechCollection->add($mechEntity, $mechFilter);
        }

        return $mechCollection;
    }
}
