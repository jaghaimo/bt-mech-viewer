<?php

namespace Btmv\Domain\Config;

class ConfigEntity
{
    /**
     * @var string[]
     */
    private $excludeDirectories;

    /**
     * @var string[]
     */
    private $includeDirectories;

    /**
     * @param string[] $includeDirectories
     * @param string[] $excludeDirectories
     */
    public function __construct(array $includeDirectories, array $excludeDirectories)
    {
        $this->includeDirectories = $includeDirectories;
        $this->excludeDirectories = $excludeDirectories;
    }

    /**
     * @return string[]
     */
    public function getExcludeDirectories(): array
    {
        return $this->excludeDirectories;
    }

    /**
     * @return string[]
     */
    public function getIncludeDirectories(): array
    {
        return $this->includeDirectories;
    }

    /**
     * @param array $array
     *
     * @return ConfigEntity
     *
     * @throws ConfigException
     */
    public static function fromArray(array $array)
    {
        try {
            return new self(
                $array['includeDirectories'],
                $array['excludeDirectories']
            );
        } catch (\Throwable $throwable) {
            throw ConfigException::missingProperty($throwable);
        }
    }
}
