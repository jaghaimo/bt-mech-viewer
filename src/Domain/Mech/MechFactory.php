<?php

namespace Btmv\Domain\Mech;

use Btmv\Utils\Json\JsonHelper;
use Symfony\Component\Finder\SplFileInfo;

class MechFactory
{
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
        $fileName = $fileInfo->getRealPath();

        try {
            $mechArray = $this->jsonHelper->read($fileName);
            $mechEntity = MechEntity::fromArray($mechArray);

            return $mechEntity;
        } catch (\Throwable $throwable) {
            throw MechFactoryException::brokenMechdef($fileName, $throwable);
        }
    }
}
