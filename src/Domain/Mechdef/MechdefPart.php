<?php

declare(strict_types=1);

namespace Btmv\Domain\Mechdef;

final class MechdefPart
{
    /** @var MechdefItem[] */
    private array $items = [];
    private string $location;

    public function __construct(array $part)
    {
        // TODO: Finish parts
        $this->location = (string) $part['Location'];
    }

    public function addItem(MechdefItem $mechdefItem): void
    {
        $this->items[] = $mechdefItem;
    }

    public function getLocation(): string
    {
        return $this->location;
    }
}
