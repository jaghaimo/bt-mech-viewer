<?php

declare(strict_types=1);

namespace Btmv\Utils\Finder;

use Symfony\Component\Finder\Finder;

final class FinderHelper
{
    /**
     * @var Finder
     */
    private $finder;

    public function __construct(Finder $finder)
    {
        $this->finder = $finder;
    }

    /**
     * @param string[] $includeDirs
     * @param string[] $excludeDirs
     */
    public function configure(array $includeDirs, array $excludeDirs, string $filename): Finder
    {
        $finder = clone $this->finder;
        $name = $this->normalize($filename);
        $finder
            ->files()
            ->in($includeDirs)
            ->exclude($excludeDirs)
            ->name($name)
        ;

        return $finder;
    }

    private function normalize(string $filter): string
    {
        return strtr($filter, ['*' => '.+']);
    }
}
