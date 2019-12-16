<?php

declare(strict_types=1);

namespace Btmv\Domain\Localization;

final class LocalizationManager
{
    const KEY_PATTERN = '__/%s/__';

    /**
     * @var array<string,string>
     */
    private $localizations = [];

    /**
     * @param array<string,string> $localizations
     */
    public function add(array $localizations): void
    {
        foreach ($localizations as $oldName => $value) {
            $key = sprintf(self::KEY_PATTERN, $oldName);
            $this->localizations[$key] = $value;
        }
    }

    public function get(string $oldName): string
    {
        return $this->localizations[$oldName] ?? $oldName;
    }
}
