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

    /**
     * @param string $bundle
     * @param array  $chassisdef
     */
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

    /**
     * @return string
     */
    public function getBundle(): string
    {
        return $this->bundle;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @return int
     */
    public function getCost(): int
    {
        return $this->cost;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return ChassisdefLocations
     */
    public function getLocations(): ChassisdefLocations
    {
        return $this->locations;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return ChassisdefTags
     */
    public function getTags(): ChassisdefTags
    {
        return $this->tags;
    }

    /**
     * @return int
     */
    public function getTonnage(): int
    {
        return $this->tonnage;
    }

    /**
     * @return string
     */
    public function getVariant(): string
    {
        return $this->variant;
    }
}
