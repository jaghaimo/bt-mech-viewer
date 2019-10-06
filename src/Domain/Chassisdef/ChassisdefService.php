<?php

namespace Btmv\Domain\Chassisdef;

use Symfony\Component\Finder\Finder;

class ChassisdefService
{
    const CHASSISDEF_PATTERN = '/^chassisdef\_%s\.json$/i';

    /**
     * @var Finder
     */
    private $finder;

    /**
     * @var ChassisdefFactory
     */
    private $chassisdefFactory;

    /**
     * @param Finder $finder
     * @param ChassisdefFactory $chassisdefFactory
     */
    public function __construct(Finder $finder, ChassisdefFactory $chassisdefFactory)
    {
        $this->finder = $finder;
        $this->chassisdefFactory = $chassisdefFactory;
    }

    /**
     * @param string[] $includeDirs
     * @param string[] $excludeDirs
     * @param string $filename
     *
     * @return ChassisdefCollection
     */
    public function findChassisdefs(array $includeDirs, array $excludeDirs, string $filename): ChassisdefCollection
    {
        $chassisdefs = [];
        $this->configureFinder($includeDirs, $excludeDirs, $filename);

        foreach ($this->finder->getIterator() as $fileInfo) {
            $chassisdef = $this->chassisdefFactory->get($fileInfo);

            if (!$chassisdef->getTags()->isBlacklisted()) {
                $chassisdefs[] = $chassisdef;
            }
        }

        return ChassisdefCollection::fromArray($chassisdefs);
    }

    /**
     * @param string[] $includeDirs
     * @param string[] $excludeDirs
     * @param string $filename
     */
    private function configureFinder(array  $includeDirs, array $excludeDirs, string $filename)
    {
        $name = sprintf(
            self::CHASSISDEF_PATTERN,
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
