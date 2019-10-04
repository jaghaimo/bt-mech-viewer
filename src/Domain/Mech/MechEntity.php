<?php

namespace Btmv\Domain\Mech;

class MechEntity
{
    /**
     * @var string
     */
    private $bundle;

    /**
     * @var int
     */
    private $cost;

    /**
     * @var string
     */
    private $class;

    /**
     * @var MechLocations
     */
    private $locations;

    /**
     * @var string
     */
    private $name;

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
     * @param string $class
     * @param string $name
     * @param int $cost
     * @param int $tonnage
     * @param string $variant
     * @param MechLocations $locations
     */
    public function __construct(
        string $bundle,
        string $class,
        string $name,
        int $cost,
        int $tonnage,
        string $variant,
        MechLocations $locations
    ) {
        $this->bundle = $bundle;
        $this->class = $class;
        $this->name = $name;
        $this->cost = $cost;
        $this->tonnage = $tonnage;
        $this->variant = $variant;
        $this->locations = $locations;
    }

    /**
     * @param array $array
     * @param string $bundle
     *
     * @return MechEntity
     *
     * @throws MechException
     */
    public static function fromArray(array $array, string $bundle): MechEntity
    {
        try {
            $arrayLower = array_change_key_case($array, CASE_LOWER);
            $arrayDescription = array_change_key_case($arrayLower['description'], CASE_LOWER);

            return new self(
                $bundle,
                ucfirst($arrayLower['weightclass']),
                ucfirst($arrayDescription['name']),
                (int) $arrayDescription['cost'],
                (int) $arrayLower['tonnage'],
                strtoupper($arrayLower['variantname']),
                MechLocations::fromArray($arrayLower['locations'])
            );
        } catch (MechException $mechException) {
            throw $mechException;
        } catch (\Throwable $throwable) {
            throw MechException::missingProperty($throwable);
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
     * @return int
     */
    public function getCost(): int
    {
        return $this->cost;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getTonnage(): int
    {
        return $this->tonnage;
    }

    /**
     * @param string $hardpointType
     *
     * @return int
     */
    public function getTotalHardpoints(string $hardpointType): int
    {
        return $this->locations->getTotalHardpoints($hardpointType);
    }

    /**
     * @return string
     */
    public function getVariant(): string
    {
        return $this->variant;
    }
}
