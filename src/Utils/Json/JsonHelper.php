<?php

declare(strict_types=1);

namespace Btmv\Utils\Json;

class JsonHelper
{
    /**
     * @param string $jsonFile
     *
     * @throws JsonNotReadException
     * @throws JsonNotDecodedException
     *
     * @return array
     */
    public function read(string $jsonFile): array
    {
        $config = @file_get_contents($jsonFile);

        if (false === $config) {
            throw new JsonNotReadException($jsonFile);
        }

        $configArray = json_decode($config, true);

        if (is_array($configArray)) {
            return $configArray;
        }

        throw new JsonNotDecodedException($jsonFile);
    }

    /**
     * @param string $jsonFile
     * @param array  $jsonObject
     *
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
