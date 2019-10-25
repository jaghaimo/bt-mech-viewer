<?php

declare(strict_types=1);

namespace Btmv\Domain\Mechdef;

use Symfony\Component\Finder\Finder;

final class MechdefService
{
    const MECHDEF_PATTERN = '/^mechdef\_%s\.json$/i';

    /**
     * @var Finder
     */
    private $finder;

    /**
     * @var MechdefReader
     */
    private $mechdefReader;

    /**
     * @param Finder        $finder
     * @param MechdefReader $mechdefReader
     */
    public function __construct(Finder $finder, MechdefReader $mechdefReader)
    {
        $this->finder = $finder;
        $this->mechdefReader = $mechdefReader;
    }

    /**
     * @param string[]      $includeDirs
     * @param string[]      $excludeDirs
     * @param string        $filename
     * @param MechdefFilter $mechdefFilter
     *
     * @return MechdefCollection
     */
    public function findMechdefs(
        array $includeDirs,
        array $excludeDirs,
        string $filename,
        MechdefFilter $mechdefFilter
    ): MechdefCollection {
        $mechdefs = [];
        $this->configureFinder($includeDirs, $excludeDirs, $filename);

        foreach ($this->finder->getIterator() as $fileInfo) {
            $mechdef = $this->mechdefReader->get($fileInfo);
            $mechdefs[] = $mechdef;
        }

        return new MechdefCollection($mechdefs, $mechdefFilter);
    }

    /**
     * @param string[] $includeDirs
     * @param string[] $excludeDirs
     * @param string   $filename
     */
    private function configureFinder(array $includeDirs, array $excludeDirs, string $filename): void
    {
        $name = sprintf(
            self::MECHDEF_PATTERN,
            $this->normalize($filename)
        );

        $this->finder
            ->files()
            ->in($includeDirs)
            ->exclude($excludeDirs)
            ->name($name)
        ;
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
