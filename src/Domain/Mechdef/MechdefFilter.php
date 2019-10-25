<?php

declare(strict_types=1);

namespace Btmv\Domain\Mechdef;

final class MechdefFilter
{
    /**
     * @var null|string
     */
    private $bundle;

    public function isMatching(MechdefEntity $entity): bool
    {
        $isMatchingBundle = true;

        if ($this->bundle) {
            $isMatchingBundle = $this->bundle === $entity->getBundle();
        }

        return $isMatchingBundle;
    }

    public function setBundle(?string $bundle): void
    {
        $this->bundle = $bundle;
    }
}
