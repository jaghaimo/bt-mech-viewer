<?php

declare(strict_types=1);

namespace Btmv\Domain\Mechdef;

final class MechdefPart
{
    /**
     * @var string
     */
    private $location;

    public function __construct(array $part)
    {
        $this->location = (string) $part['Location'];
    }

    public function getLocation(): string
    {
        return $this->location;
    }
}
