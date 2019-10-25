<?php

declare(strict_types=1);

namespace Btmv\Command\Table;

use Btmv\Domain\FilterAwareCollection;

final class FilterAwareCollectionFooter
{
    const PLURAL = 's';

    public function getFooter(FilterAwareCollection $filterableCollection, string $name): string
    {
        $totalCount = $filterableCollection->getTotalCount();
        $matchingCount = $filterableCollection->getMatchingCount();
        $filteredCount = $totalCount - $matchingCount;

        if (1 !== $filteredCount) {
            $name .= self::PLURAL;
        }

        $footer = "Found {$matchingCount} {$name} matching your query";

        if ($filteredCount > 0) {
            $footer .= " ({$filteredCount} removed by filters)";
        }

        return $footer;
    }
}
