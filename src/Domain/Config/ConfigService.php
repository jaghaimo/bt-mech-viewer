<?php

namespace Btmv\Domain\Config;

use Btmv\Utils\Json\JsonHelper;
use Btmv\Utils\Json\JsonNotDecodedException;
use Btmv\Utils\Json\JsonNotReadException;

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
     *
     * @throws ConfigException
     */
    public function getConfig(): ConfigEntity
    {
        try {
            $configArray = $this->jsonHelper->read($this->configFile);

            return ConfigEntity::fromArray($configArray);
        } catch (JsonNotReadException $exception) {
            throw ConfigException::couldNotRead($exception);
        } catch (JsonNotDecodedException $exception) {
            throw ConfigException::couldNotDecode($exception);
        }
    }
}
