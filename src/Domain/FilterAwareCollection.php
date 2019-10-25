<?php

declare(strict_types=1);

namespace Btmv\Domain;

interface FilterAwareCollection
{
    public function getMatchingCount(): int;

    public function getTotalCount(): int;
}
