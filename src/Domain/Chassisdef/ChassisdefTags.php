<?php

declare(strict_types=1);

namespace Btmv\Domain\Chassisdef;

final class ChassisdefTags
{
    const TAG_BLACKLISTED = 'blacklisted';
    const TAG_CLAN = 'clanmech';
    const TAG_ELITE = 'elitemech';
    const TAG_EMPTY = ' ';
    const TAG_HERO = 'heromech';
    const TAG_OMNI = 'omnimech';
    const TAG_PRIMITIVE = 'primitive';
    const TAG_PROJECTB = 'projectb';
    const TAG_PROTO = 'protomech';
    const TAG_PROTOTYPE = 'prototypemech';
    const TAG_RISC = 'riscbattlemech';
    const TAG_SLDF = 'sldfmech';
    const TAG_SOCIETY = 'societymech';
    const TAG_SUPERHEAVY = 'superheavy';

    private array $tags = [];

    public function __construct(array $tags)
    {
        foreach ($tags['items'] as $tag) {
            $tagLower = strtolower($tag);
            $this->tags[$tagLower] = $tagLower;
        }
    }

    public function getShortTags(): string
    {
        $clanTag = $this->isClan() ? self::TAG_CLAN[0] : self::TAG_EMPTY;
        $omniTag = $this->isOmni() ? self::TAG_OMNI[0] : self::TAG_EMPTY;

        return strtoupper($clanTag . $omniTag);
    }

    public function isBlacklisted(): bool
    {
        return $this->hasTag(self::TAG_BLACKLISTED);
    }

    public function isClan(): bool
    {
        return $this->hasTag(self::TAG_CLAN);
    }

    public function isOmni(): bool
    {
        return $this->hasTag(self::TAG_OMNI);
    }

    private function hasTag(string $tag): bool
    {
        return  array_key_exists($tag, $this->tags);
    }
}
