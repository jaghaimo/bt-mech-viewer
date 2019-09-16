<?php

namespace Btmv\Domain\Config;

use Btmv\Utils\Json\JsonHelper;
use Btmv\Utils\Json\JsonNotDecodedException;
use Btmv\Utils\Json\JsonNotEncodedException;
use Btmv\Utils\Json\JsonNotReadException;
use Btmv\Utils\Json\JsonNotWrittenException;

class ConfigService
{
    const DEFAULT_CONFIG_FILE = 'btmv.json';

    /**
     * @var string
     */
    private $configFile;

    /**
     * @var JsonHelper
     */
    private $jsonHelper;

    /**
     * @param JsonHelper $jsonHelper
     * @param string $configFile
     */
    public function __construct(JsonHelper $jsonHelper, string $configFile)
    {
        $this->jsonHelper = $jsonHelper;
        $this->configFile = $configFile;
    }

    /**
     * @return ConfigEntity
     */
    public function getConfig(): ConfigEntity
    {
        $configObject = $this->readConfig();

        return ConfigEntity::fromArray($configObject);
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return string
     */
    public function setConfig(string $key, string $value): string
    {
        $configArray = $this->readConfig();

        if (!array_key_exists($key, $configArray)) {
            throw ConfigException::missingProperty($key);
        }

        $previousValue = $configArray[$key];
        $configArray[$key] = $value;

        try {
            $this->jsonHelper->write($this->configFile, $configArray);
        } catch (JsonNotEncodedException $exception) {
            throw ConfigException::couldNotEncode($exception);
        } catch (JsonNotWrittenException $exception) {
            throw ConfigException::couldNotWrite($exception);
        }

        return $previousValue;
    }

    /**
     * @return array
     */
    private function readConfig(): array
    {
        try {
            $configObject = $this->jsonHelper->read($this->configFile);

            return $configObject;
        } catch (JsonNotReadException $exception) {
            throw ConfigException::couldNotRead($exception);
        } catch (JsonNotDecodedException $exception) {
            throw ConfigException::couldNotDecode($exception);
        }
    }
}
