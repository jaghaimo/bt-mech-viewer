<?php

namespace Btmv\Domain\Mech;

class MechEntity
{
    /**
     * @var string
     */
    private $class;

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
     * @var MechLocations
     */
    private $locations;

    /**
     * @param string $class
     * @param string $name
     * @param int $tonnage
     * @param string $variant
     * @param MechLocations $locations
     */
    public function __construct(string $class, string $name, int $tonnage, string $variant, MechLocations $locations)
    {
        $this->class = $class;
        $this->name = $name;
        $this->tonnage = $tonnage;
        $this->variant = $variant;
        $this->locations = $locations;
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
     * @return string
     */
    public function getVariant(): string
    {
        return $this->variant;
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
     * @param array $array
     *
     * @return MechEntity
     *
     * @throws MechException
     */
    public static function fromArray(array $array): MechEntity
    {
        try {
            $arrayLower = array_change_key_case($array, CASE_LOWER);
            $arrayDescription = array_change_key_case($arrayLower['description'], CASE_LOWER);

            return new self(
                ucfirst($arrayLower['weightclass']),
                ucfirst($arrayDescription['name']),
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
}
