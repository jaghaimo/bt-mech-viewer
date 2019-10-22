<?php

declare(strict_types=1);

namespace Btmv\Domain;

class EntityException extends \Exception
{
    /**
     * @param \Throwable $throwable
     *
     * @return string
     */
    public static function getPropertyName(\Throwable $throwable)
    {
        return (string) substr($throwable->getMessage(), 25);
    }
}
