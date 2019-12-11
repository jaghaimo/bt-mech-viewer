<?php

declare(strict_types=1);

namespace Btmv\Domain;

abstract class EntityException extends \Exception
{
    public static function getPropertyName(\Throwable $throwable): string
    {
        return (string) substr($throwable->getMessage(), 25);
    }
}
