<?php

namespace Btmv\Domain\Mech;

class MechTags
{
    const TAG_BLACKLISTED = 'blacklisted';
    const TAG_CLAN = 'clanmech';
    const TAG_ELITE = 'elitemech';
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

    /**
     * @var bool
     */
    private $isClan = false;

    /**
     * @var bool
     */
    private $isOmni = false;

    /**
     * @return string
     */
    public function getShortTags(): string
    {
        $clanTag = $this->isClan() ? self::TAG_CLAN[0] : ' ';
        $omniTag = $this->isOmni() ? self::TAG_OMNI[0] : ' ';

        return strtoupper($clanTag . ' ' . $omniTag);
    }

    /**
     * @return bool
     */
    public function isClan(): bool
    {
        return $this->isClan;
    }

    /**
     * @return bool
     */
    public function isOmni(): bool
    {
        return $this->isOmni;
    }

    /**
     * @param bool $isClan
     */
    public function setClan(bool $isClan): void
    {
        $this->isClan = $isClan;
    }

    /**
     * @param bool $isOmni
     */
    public function setOmni(bool $isOmni): void
    {
        $this->isOmni = $isOmni;
    }

    /**
     * @param array $array
     *
     * @return MechTags
     */
    public static function fromArray(array $array): MechTags
    {
        $mechTags = new MechTags();

        foreach ($array['items'] as $tag) {
            $tagLower = strtolower($tag);
            
            switch ($tagLower) {
                case self::TAG_CLAN:
                    $mechTags->setClan(true);
                    break;
                case self::TAG_OMNI:
                    $mechTags->setOmni(true);
                    break;
                case self::TAG_BLACKLISTED:
                case self::TAG_ELITE:
                case self::TAG_HERO:
                case self::TAG_PRIMITIVE:
                case self::TAG_PROJECTB:
                case self::TAG_PROTO:
                case self::TAG_PROTOTYPE:
                case self::TAG_RISC:
                case self::TAG_SLDF:
                case self::TAG_SOCIETY:
                case self::TAG_SUPERHEAVY:
                    break;
            }
        }

        return $mechTags;
    }
}
