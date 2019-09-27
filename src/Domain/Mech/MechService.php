<?php

namespace Btmv\Domain\Mech;

use Symfony\Component\Finder\Finder;

class MechService
{
    const MECHDEF_PATTERN = '/^chassisdef\_%s\_%s\.json$/i';

    /**
     * @var Finder
     */
    private $finder;

    /**
     * @var MechFactory
     */
    private $mechFactory;

    /**
     * @param Finder $finder
     * @param MechFactory $mechFactory
     */
    public function __construct(Finder $finder, MechFactory $mechFactory)
    {
        $this->finder = $finder;
        $this->mechFactory = $mechFactory;
    }

    /**
     * @param string $directory
     * @param string $nameFilter
     * @param string $variantFilter
     *
     * @return MechCollection
     */
    public function findMechs(string $directory, string $nameFilter, string $variantFilter): MechCollection
    {
        $mechs = [];
        $this->configureFinder($directory, $nameFilter, $variantFilter);

        foreach ($this->finder->getIterator() as $fileInfo) {
            $mechs[] = $this->mechFactory->get($fileInfo);
        }

        return MechCollection::fromArray($mechs);
    }

    /**
     * @param string $directory
     * @param string $nameFilter
     * @param string $variantFilter
     */
    private function configureFinder(string $directory, string $nameFilter, string $variantFilter)
    {
        $name = sprintf(
            self::MECHDEF_PATTERN,
            $this->normalize($nameFilter),
            $this->normalize($variantFilter)
        );

        $this->finder
            ->files()
            ->in($directory)
            ->name($name);
    }

    /**
     * @param string $filter
     *
     * @return string
     */
    private function normalize(string $filter): string
    {
        return strtr($filter, ['*' => '.+']);
    }
}
