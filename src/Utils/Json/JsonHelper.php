<?php

declare(strict_types=1);

namespace Btmv\Utils\Json;

final class JsonHelper
{
    /**
     * @throws JsonNotReadException
     * @throws JsonNotDecodedException
     */
    public function read(string $jsonFile): array
    {
        $config = @file_get_contents($jsonFile);

        if (false === $config) {
            throw new JsonNotReadException($jsonFile);
        }

        $configArray = json5_decode($config, true);

        if (is_array($configArray)) {
            return $configArray;
        }

        throw new JsonNotDecodedException($jsonFile);
    }

    /**
     * @throws JsonNotEncodedException
     * @throws JsonNotWrittenException
     */
    public function write(string $jsonFile, array $jsonObject): void
    {
        $jsonEncoded = json_encode($jsonObject);

        if (false === $jsonEncoded) {
            throw new JsonNotEncodedException($jsonFile);
        }

        $bytesWritten = file_put_contents($jsonFile, $jsonEncoded);

        if (false === $bytesWritten) {
            throw new JsonNotWrittenException($jsonFile);
        }
    }
}
