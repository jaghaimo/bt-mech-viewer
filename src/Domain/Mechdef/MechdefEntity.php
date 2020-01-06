<?php

declare(strict_types=1);

namespace Btmv\Domain\Mechdef;

final class MechdefEntity
{
    private string $bundle;
    private string $chassisId;
    private string $id;
    private MechdefLocations $locations;
    private string $name;

    public function __construct(string $bundle, array $mechdef)
    {
        $this->bundle = $bundle;
        $this->chassisId = strtolower($mechdef['ChassisID']);
        $this->id = strtolower($mechdef['Description']['Id']);
        $this->locations = new MechdefLocations($mechdef['Locations'], $mechdef['inventory']);
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
