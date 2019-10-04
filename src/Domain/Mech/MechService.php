<?php

namespace Btmv\Domain\Mech;

use Symfony\Component\Finder\Finder;

class MechService
{
    const MECHDEF_PATTERN = '/^chassisdef\_%s\.json$/i';

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
     * @param string[] $includeDirs
     * @param string[] $excludeDirs
     * @param string $filename
     *
     * @return MechCollection
     */
    public function findMechs(array $includeDirs, array $excludeDirs, string $filename): MechCollection
    {
        $mechs = [];
        $this->configureFinder($includeDirs, $excludeDirs, $filename);

        foreach ($this->finder->getIterator() as $fileInfo) {
            $mechs[] = $this->mechFactory->get($fileInfo);
        }

        return MechCollection::fromArray($mechs);
    }

    /**
     * @param string[] $includeDirs
     * @param string[] $excludeDirs
     * @param string $filename
     */
    private function configureFinder(array  $includeDirs, array $excludeDirs, string $filename)
    {
        $name = sprintf(
            self::MECHDEF_PATTERN,
            $this->normalize($filename)
        );

        $this->finder
            ->files()
            ->in($includeDirs)
            ->exclude($excludeDirs)
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
