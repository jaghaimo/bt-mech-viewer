<?php

declare(strict_types=1);

namespace Btmv\Domain\Mechdef;

final class MechdefInventory
{
    /**
     * @var MechdefItem[]
     */
    private $inventory = [];

    public function __construct(array $inventory)
    {
        foreach ($inventory as $item) {
            $this->inventory[] = new MechdefItem($item);
        }
    }
}
