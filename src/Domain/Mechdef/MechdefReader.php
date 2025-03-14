<?php

declare(strict_types=1);

namespace Btmv\Domain\Mechdef;

use Btmv\Utils\Json\JsonHelper;
use Symfony\Component\Finder\SplFileInfo;

final class MechdefReader
{
    // Location where bundle information is stored (relative to chassidef file)
    const BUNDLE_OFFSET = 3;

    private JsonHelper $jsonHelper;

    public function __construct(JsonHelper $jsonHelper)
    {
        $this->jsonHelper = $jsonHelper;
    }

    /**
     * @throws MechdefReaderException
     */
    public function get(SplFileInfo $fileInfo): MechdefEntity
    {
        $mechdefPath = $fileInfo->getRealPath();
        $mechdefChunks = explode(DIRECTORY_SEPARATOR, $mechdefPath);
        $totalChunks = count($mechdefChunks);
        $bundle = $mechdefChunks[$totalChunks - self::BUNDLE_OFFSET];

        try {
            $mechdef = $this->jsonHelper->read($mechdefPath);

            return new MechdefEntity($bundle, $mechdef);
        } catch (\Throwable $throwable) {
            throw MechdefReaderException::brokenMechdef($mechdefPath, $throwable);
        }
    }
}
