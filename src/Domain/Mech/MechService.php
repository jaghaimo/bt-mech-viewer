<?php

namespace Btmv\Domain\Mech;

use Symfony\Component\Finder\Finder;

class MechService
{
    const MECHDEF_PATTERN = 'chassisdef_*.json';

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
     *
     * @return MechCollection
     */
    public function findMechs(string $directory): MechCollection
    {
        $mechs = [];
        $this->configureFinder($directory);

        foreach ($this->finder->getIterator() as $fileInfo) {
            $mechs[] = $this->mechFactory->get($fileInfo);
        }

        return MechCollection::fromArray($mechs);
    }

    /**
     * @param string $directory
     */
    private function configureFinder(string $directory)
    {
        $this->finder
            ->files()
            ->in($directory)
            ->name(self::MECHDEF_PATTERN);
    }
}
