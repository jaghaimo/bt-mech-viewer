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
     * @param string $class
     * @param string $name
     * @param int $tonnage
     * @param string $variant
     */
    public function __construct(string $class, string $name, int $tonnage, string $variant)
    {
        $this->class = $class;
        $this->name = $name;
        $this->tonnage = $tonnage;
        $this->variant = $variant;
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
     * @param array $array
     *
     * @return MechEntity
     *
     * @throws MechException
     */
    public static function fromObject(array $array)
    {
        try {
            $arrayLower = array_change_key_case($array, CASE_LOWER);
            $arrayDescription = array_change_key_case($arrayLower['description'], CASE_LOWER);

            return new self(
                ucfirst($arrayLower['weightclass']),
                ucfirst($arrayDescription['name']),
                (int)$arrayLower['tonnage'],
                strtoupper($arrayLower['variantname'])
            );
        } catch (\Throwable $throwable) {
            throw MechException::missingProperty($throwable);
        }
    }
}
