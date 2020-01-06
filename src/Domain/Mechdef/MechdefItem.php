<?php

declare(strict_types=1);

namespace Btmv\Domain\Mechdef;

final class MechdefItem
{
    private string $location;

    public function __construct(array $item)
    {
        // TODO: Finish inventory
        $this->location = $item['MountedLocation'];
    }

    public function getLocation(): string
    {
        return $this->location;
    }
}
