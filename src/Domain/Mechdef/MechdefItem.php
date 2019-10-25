<?php

declare(strict_types=1);

namespace Btmv\Domain\Mechdef;

final class MechdefItem
{
    /**
     * @var string
     */
    private $location;

    public function __construct(array $item)
    {
        $this->location = $item['MountedLocation'];
    }
}
