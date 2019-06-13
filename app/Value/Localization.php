<?php
namespace App\Values\Localizations;

use App\Values\Value;
use Locale;

class Localization extends Value
{
    /**
     * @var null
     */
    private $language = null;

    /**
     * @var array
     */
    private $regions = [];

    /**
     * Localization constructor.
     *
     * @param       $language
     * @param array $regions
     */
    public function __construct($language, array $regions = [])
    {
        $this->language = $language;

        foreach ($regions as $region) {
            $this->regions[] = new Region($region);
        }
    }

    /**
     * @return string
     */
    public function getDefaultName()
    {
        return Locale::getDisplayLanguage($this->language, config('app.locale'));
    }

    /**
     * @return string
     */
    public function getLocaleName()
    {
        return Locale::getDisplayLanguage($this->language, $this->language);
    }

    /**
     * @return string|null
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return array
     */
    public function getRegions()
    {
        return $this->regions;
    }
}
