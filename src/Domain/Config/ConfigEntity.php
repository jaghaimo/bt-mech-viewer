<?php

namespace Btmv\Domain\Config;

class ConfigEntity
{
    /**
     * @var string
     */
    private $modsDirectory;

    /**
     * @param string $modsDirectory
     */
    public function __construct(string $modsDirectory)
    {
        $this->modsDirectory = $modsDirectory;
    }

    /**
     * @return string
     */
    public function getModsDirectory(): string
    {
        return $this->modsDirectory;
    }

    /**
     * @param array $array
     *
     * @return ConfigEntity
     */
    public static function fromArray(array $array)
    {
        try {
            return new self(
                $array['modsDirectory']
            );
        } catch (\Throwable $throwable) {
            throw ConfigException::missingProperty($throwable);
        }
    }
}
