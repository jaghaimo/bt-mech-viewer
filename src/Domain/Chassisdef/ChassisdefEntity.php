<?php

declare(strict_types=1);

namespace Btmv\Domain\Chassisdef;

final class ChassisdefEntity
{
    /**
     * @var string
     */
    private $bundle;

    /**
     * @var string
     */
    private $class;

    /**
     * @var int
     */
    private $cost;

    /**
     * @var string
     */
    private $id;

    /**
     * @var ChassisdefLocations
     */
    private $locations;

    /**
     * @var string
     */
    private $name;

    /**
     * @var ChassisdefTags
     */
    private $tags;

    /**
     * @var int
     */
    private $tonnage;

    /**
     * @var string
     */
    private $variant;

    public function __construct(
        string $bundle,
        array $chassisdef
    ) {
        $this->id = strtolower($chassisdef['Description']['Id']);
        $this->bundle = $bundle;
        $this->class = ucfirst($chassisdef['weightClass']);
        $this->name = ucfirst($chassisdef['Description']['Name']);
        $this->cost = (int) $chassisdef['Description']['Cost'];
        $this->tonnage = (int) $chassisdef['Tonnage'];
        $this->variant = strtoupper($chassisdef['VariantName']);

        $this->locations = new ChassisdefLocations($chassisdef['Locations']);
        $this->tags = new ChassisdefTags($chassisdef['ChassisTags']);
    }

    public function getBundle(): string
    {
        return $this->bundle;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getCost(): int
    {
        return $this->cost;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLocations(): ChassisdefLocations
    {
        return $this->locations;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTags(): ChassisdefTags
    {
        return $this->tags;
    }

    public function getTonnage(): int
    {
        return $this->tonnage;
    }

    public function getVariant(): string
    {
        return $this->variant;
    }
}
