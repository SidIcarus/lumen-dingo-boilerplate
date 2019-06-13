<?php
namespace App\Values\Localizations;

use App\Values\Value;
use Locale;

class Region extends Value
{
    /**
     * @var null
     */
    private $region = null;

    /**
     * Region constructor.
     *
     * @param $region
     */
    public function __construct($region)
    {
        $this->region = $region;
    }

    /**
     * @return string
     */
    public function getDefaultName()
    {
        return Locale::getDisplayRegion($this->region, config('app.locale'));
    }

    /**
     * @return string
     */
    public function getLocaleName()
    {
        return Locale::getDisplayRegion($this->region, $this->region);
    }

    /**
     * @return string|null
     */
    public function getRegion()
    {
        return $this->region;
    }
}
