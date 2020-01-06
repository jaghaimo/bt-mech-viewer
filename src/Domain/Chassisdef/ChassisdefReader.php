<?php

declare(strict_types=1);

namespace Btmv\Domain\Chassisdef;

use Btmv\Utils\Json\JsonHelper;
use Symfony\Component\Finder\SplFileInfo;

final class ChassisdefReader
{
    // Location where bundle information is stored (relative to chassidef file)
    const BUNDLE_OFFSET = 3;

    private JsonHelper $jsonHelper;

    public function __construct(JsonHelper $jsonHelper)
    {
        $this->jsonHelper = $jsonHelper;
    }

    /**
     * @throws ChassisdefReaderException
     */
    public function get(SplFileInfo $fileInfo): ChassisdefEntity
    {
        $chassisdefPath = $fileInfo->getRealPath();
        $chassisdefChunks = explode(DIRECTORY_SEPARATOR, $chassisdefPath);
        $totalChunks = count($chassisdefChunks);
        $bundle = $chassisdefChunks[$totalChunks - self::BUNDLE_OFFSET];

        try {
            $chassisdef = $this->jsonHelper->read($chassisdefPath);

            return new ChassisdefEntity($bundle, $chassisdef);
        } catch (\Throwable $throwable) {
            throw ChassisdefReaderException::brokenChassisdef($chassisdefPath, $throwable);
        }
    }
}
