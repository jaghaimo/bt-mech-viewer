<?php

declare(strict_types=1);

namespace Btmv\Domain\Chassisdef;

use Symfony\Component\Finder\Finder;

final class ChassisdefService
{
    const CHASSISDEF_PATTERN = '/^chassisdef\_%s\.json$/i';

    /**
     * @var ChassisdefReader
     */
    private $chassisdefReader;

    /**
     * @var Finder
     */
    private $finder;

    public function __construct(Finder $finder, ChassisdefReader $chassisdefReader)
    {
        $this->finder = $finder;
        $this->chassisdefReader = $chassisdefReader;
    }

    /**
     * @param string[] $includeDirs
     * @param string[] $excludeDirs
     */
    public function findChassisdefs(
        array $includeDirs,
        array $excludeDirs,
        string $filename,
        ChassisdefFilter $chassisdefFilter
    ): ChassisdefCollection {
        $chassisdefs = [];
        $this->configureFinder($includeDirs, $excludeDirs, $filename);

        foreach ($this->finder->getIterator() as $fileInfo) {
            $chassisdef = $this->chassisdefReader->get($fileInfo);
            $chassisdefs[] = $chassisdef;
        }

        return new ChassisdefCollection($chassisdefs, $chassisdefFilter);
    }

    /**
     * @param string[] $includeDirs
     * @param string[] $excludeDirs
     */
    private function configureFinder(array $includeDirs, array $excludeDirs, string $filename): void
    {
        $name = sprintf(
            self::CHASSISDEF_PATTERN,
            $this->normalize($filename)
        );

        $this->finder
            ->files()
            ->in($includeDirs)
            ->exclude($excludeDirs)
            ->name($name)
        ;
    }

    private function normalize(string $filter): string
    {
        return strtr($filter, ['*' => '.+']);
    }
}
