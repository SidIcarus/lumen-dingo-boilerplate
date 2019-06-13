<?php declare(strict_types=1);

namespace App\Value;

use App\Value\Base as Value;
use Locale;

/**
 * Localization Value Class
 *
 * @package Adventive\Value
 */
final class Localization extends Value
{
    /**
     * @var string|null
     */
    private $language;

    /**
     * @var array
     */
    private $regions = [];

    /**
     * Localization Value Constructor
     *
     * @param string|null $language
     * @param array $regions
     */
    public function __construct(?string $language, array $regions = [])
    {
        $this->language = $language;

        foreach ($regions as $region) {
            $this->regions[] = new Region($region);
        }
    }

    /**
     * @todo add summary
     *
     * @return string
     */
    public function getDefaultName(): string
    {
        return Locale::getDisplayLanguage(
            $this->language,
            config('app.locale')
        );
    }

    /**
     * @todo add summary
     *
     * @return string
     */
    public function getLocaleName(): string
    {
        return Locale::getDisplayLanguage($this->language, $this->language);
    }

    /**
     * @todo add summary
     *
     * @return string|null
     */
    public function getLanguage(): ?string
    {
        return $this->language;
    }

    /**
     * @todo add summary
     *
     * @return array
     */
    public function getRegions(): array
    {
        return $this->regions;
    }
}
