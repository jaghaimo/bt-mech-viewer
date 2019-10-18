<?php

namespace Btmv\Domain\Config;

use Btmv\Domain\EntityException;

class ConfigException extends EntityException
{
    /**
     * @param \Throwable $throwable
     *
     * @return ConfigException
     */
    public static function couldNotDecode(\Throwable $throwable): ConfigException
    {
        return new self('Could not decode contents of config file', 0, $throwable);
    }

    /**
     * @param \Throwable $throwable
     *
     * @return ConfigException
     */
    public static function couldNotEncode(\Throwable $throwable): ConfigException
    {
        return new self('Could not encode config', 0, $throwable);
    }

    /**
     * @param \Throwable $throwable
     *
     * @return ConfigException
     */
    public static function couldNotRead(\Throwable $throwable): ConfigException
    {
        return new self('Could not read config file', 0, $throwable);
    }

    /**
     * @param \Throwable $throwable
     *
     * @return ConfigException
     */
    public static function couldNotWrite(\Throwable $throwable): ConfigException
    {
        return new self('Could not write config file', 0, $throwable);
    }

    /**
     * @param \Throwable $throwable
     *
     * @return ConfigException
     */
    public static function missingProperty(\Throwable $throwable): ConfigException
    {
        $property = self::getPropertyName($throwable);

        return new self("Missing config property: {$property}");
    }
}
