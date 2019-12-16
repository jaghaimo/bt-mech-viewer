<?php

declare(strict_types=1);

namespace Btmv\Domain\Mechdef;

final class MechdefEntity
{
    /**
     * @var string
     */
    private $bundle;
    /**
     * @var string
     */
    private $chassisId;

    /**
     * @var string
     */
    private $id;

    /**
     * @var MechdefInventory
     */
    private $inventory;

    /**
     * @var MechdefLocations
     */
    private $locations;

    /**
     * @var string
     */
    private $name;

    public function __construct(string $bundle, array $mechdef)
    {
        $this->bundle = $bundle;
        $this->chassisId = $mechdef['ChassisID'];
        $this->id = $mechdef['Description']['Id'];
        $this->inventory = new MechdefInventory($mechdef['inventory']);
        $this->locations = new MechdefLocations($mechdef['Locations']);
        $this->name = $mechdef['Description']['UIName'];
    }

    public function getBundle(): string
    {
        return $this->bundle;
    }

    public function getChassisId(): string
    {
        return $this->chassisId;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getItems(): MechdefInventory
    {
        return $this->inventory;
    }

    public function getLocations(): MechdefLocations
    {
        return $this->locations;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
