<?php

namespace Btmv\Domain\Chassisdef;

class ChassisdefEntity
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
     * @param string              $id
     * @param string              $bundle
     * @param string              $class
     * @param string              $name
     * @param int                 $cost
     * @param int                 $tonnage
     * @param string              $variant
     * @param ChassisdefLocations $locations
     * @param ChassisdefTags      $tags
     */
    public function __construct(
        string $id,
        string $bundle,
        string $class,
        string $name,
        int $cost,
        int $tonnage,
        string $variant,
        ChassisdefLocations $locations,
        ChassisdefTags $tags
    ) {
        $this->id = $id;
        $this->bundle = $bundle;
        $this->class = $class;
        $this->name = $name;
        $this->cost = $cost;
        $this->tonnage = $tonnage;
        $this->variant = $variant;
        $this->locations = $locations;
        $this->tags = $tags;
    }

    /**
     * @param array  $chassisDef
     * @param string $bundle
     *
     * @throws ChassisdefException
     *
     * @return ChassisdefEntity
     */
    public static function fromArray(array $chassisDef, string $bundle): ChassisdefEntity
    {
        try {
            $arrayLower = array_change_key_case($chassisDef, CASE_LOWER);
            $arrayDescription = array_change_key_case($arrayLower['description'], CASE_LOWER);

            return new self(
                strtolower($arrayDescription['id']),
                $bundle,
                ucfirst($arrayLower['weightclass']),
                ucfirst($arrayDescription['name']),
                (int) $arrayDescription['cost'],
                (int) $arrayLower['tonnage'],
                strtoupper($arrayLower['variantname']),
                ChassisdefLocations::fromArray($arrayLower['locations']),
                ChassisdefTags::fromArray($arrayLower['chassistags'])
            );
        } catch (ChassisdefException $chassisdefException) {
            throw $chassisdefException;
        } catch (\Throwable $throwable) {
            throw ChassisdefException::missingProperty($throwable);
        }
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
