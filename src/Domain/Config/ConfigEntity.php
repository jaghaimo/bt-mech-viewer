<?php

declare(strict_types=1);

namespace Btmv\Domain\Config;

final class ConfigEntity
{
    /** @var string[] */
    private array $excludeDirectories;
    /** @var string[] */
    private array $includeDirectories;

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
     * @throws ConfigException
     */
    public static function fromArray(array $array): ConfigEntity
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
}
