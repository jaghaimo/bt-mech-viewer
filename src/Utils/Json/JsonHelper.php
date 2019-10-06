<?php

namespace Btmv\Utils\Json;

class JsonHelper
{
    /**
     * @param string $jsonFile
     *
     * @return array
     *
     * @throws JsonNotReadException
     * @throws JsonNotDecodedException
     */
    public function read(string $jsonFile): array
    {
        $config = @file_get_contents($jsonFile);

        if ($config === false) {
            throw new JsonNotReadException($jsonFile);
        }

        $configArray = json_decode($config, true);

        if ($configArray === null) {
            throw new JsonNotDecodedException($jsonFile);
        }

        return $configArray;
    }

    /**
     * @param string $jsonFile
     * @param array $jsonObject
     *
     * @throws JsonNotEncodedException
     * @throws JsonNotWrittenException
     */
    public function write(string $jsonFile, array $jsonObject)
    {
        $jsonEncoded = json_encode($jsonObject);

        if ($jsonEncoded === false) {
            throw new JsonNotEncodedException($jsonFile);
        }

        $bytesWritten = file_put_contents($jsonFile, $jsonEncoded);

        if ($bytesWritten === false) {
            throw new JsonNotWrittenException($jsonFile);
        }
    }
}
