<?php declare(strict_types=1);

namespace App\Value;

use App\Value\Base as Value;
use Locale;


final class Localization extends Value
{

    private $language;


    private $regions = [];


    public function __construct(?string $language, array $regions = [])
    {
        $this->language = $language;

        foreach ($regions as $region) {
            $this->regions[] = new Region($region);
        }
    }


    public function getDefaultName(): string
    {
        return Locale::getDisplayLanguage(
            $this->language,
            config('app.locale')
        );
    }


    public function getLocaleName(): string
    {
        return Locale::getDisplayLanguage($this->language, $this->language);
    }


    public function getLanguage(): ?string
    {
        return $this->language;
    }


    public function getRegions(): array
    {
        return $this->regions;
    }
}
