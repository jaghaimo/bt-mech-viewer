<?php

namespace Btmv\Domain\Config;

use Btmv\Utils\Json\JsonHelper;
use Btmv\Utils\Json\JsonNotDecodedException;
use Btmv\Utils\Json\JsonNotReadException;

class ConfigService
{
    const DEFAULT_CONFIG_FILE = 'btmv.json';

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
     * @param string $configFile
     *
     * @return ConfigEntity
     *
     * @throws ConfigException
     */
    public function getConfig(string $configFile = self::DEFAULT_CONFIG_FILE): ConfigEntity
    {
        try {
            $configArray = $this->jsonHelper->read($configFile);

            return ConfigEntity::fromArray($configArray);
        } catch (JsonNotReadException $exception) {
            throw ConfigException::couldNotRead($exception);
        } catch (JsonNotDecodedException $exception) {
            throw ConfigException::couldNotDecode($exception);
        }
    }
}
