<?php

namespace Btmv\Domain\Mech;

use Btmv\Utils\Json\JsonHelper;
use Symfony\Component\Finder\SplFileInfo;

class MechFactory
{
    const BUNDLE_OFFSET = 3;

    /**
     * @var JsonHelper
     */
    private $jsonHelper;

    /**
     * @param JsonHelper $jsonHelper
     */
    public function __construct(JsonHelper $jsonHelper)
    {
        $this->jsonHelper = $jsonHelper;
    }

    /**
     * @param SplFileInfo $fileInfo
     *
     * @return MechEntity
     *
     * @throws MechFactoryException
     */
    public function get(SplFileInfo $fileInfo)
    {
        $chassisDef = $fileInfo->getRealPath();
        $chassisDefChunks = explode(DIRECTORY_SEPARATOR, $chassisDef);
        $totalChunks = count($chassisDefChunks);
        $bundle = $chassisDefChunks[$totalChunks - self::BUNDLE_OFFSET];

        try {
            $mechArray = $this->jsonHelper->read($chassisDef);
            $mechEntity = MechEntity::fromArray($mechArray, $bundle);

            return $mechEntity;
        } catch (\Throwable $throwable) {
            throw MechFactoryException::brokenMechdef($chassisDef, $throwable);
        }
    }
}
