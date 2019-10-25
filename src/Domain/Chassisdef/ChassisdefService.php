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

    /**
     * @param Finder           $finder
     * @param ChassisdefReader $chassisdefReader
     */
    public function __construct(Finder $finder, ChassisdefReader $chassisdefReader)
    {
        $this->finder = $finder;
        $this->chassisdefReader = $chassisdefReader;
    }

    /**
     * @param string[]         $includeDirs
     * @param string[]         $excludeDirs
     * @param string           $filename
     * @param ChassisdefFilter $chassisdefFilter
     *
     * @return ChassisdefCollection
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
     * @param string   $filename
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
