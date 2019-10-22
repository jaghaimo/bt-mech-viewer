<?php

declare(strict_types=1);

namespace Btmv\Domain\Chassisdef;

use Btmv\Utils\Json\JsonHelper;
use Symfony\Component\Finder\SplFileInfo;

class ChassisdefFactory
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
     * @throws ChassisdefFactoryException
     *
     * @return ChassisdefEntity
     */
    public function get(SplFileInfo $fileInfo)
    {
        $chassisdef = $fileInfo->getRealPath();
        $chassisdefChunks = explode(DIRECTORY_SEPARATOR, $chassisdef);
        $totalChunks = count($chassisdefChunks);
        $bundle = $chassisdefChunks[$totalChunks - self::BUNDLE_OFFSET];

        try {
            $chassisdefArray = $this->jsonHelper->read($chassisdef);

            return ChassisdefEntity::fromArray($chassisdefArray, $bundle);
        } catch (\Throwable $throwable) {
            throw ChassisdefFactoryException::brokenChassisdef($chassisdef, $throwable);
        }
    }
}
