<?php declare(strict_types=1);

namespace App\Value;

use App\Value\Base as Value;
use Locale;


final class Region extends Value
{

    private $region;


    public function __construct(?string $region)
    {
        $this->region = $region;
    }


    public function getDefaultName(): string
    {
        return Locale::getDisplayRegion($this->region, config('app.locale'));
    }


    public function getLocaleName(): string
    {
        return Locale::getDisplayRegion($this->region, $this->region);
    }


    public function getRegion(): ?string
    {
        return $this->region;
    }
}
