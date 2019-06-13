<?php declare(strict_types=1);

namespace App\Value;

use App\Value\Base as Value;
use Locale;

/**
 * Region Value Class
 *
 * @package Adventive\Value
 */
final class Region extends Value
{
    /**
     * @var string|null
     */
    private $region;

    /**
     * Region Value Constructor
     *
     * @param string|null $region
     */
    public function __construct(?string $region)
    {
        $this->region = $region;
    }

    /**
     * @todo add summary
     *
     * @return string
     */
    public function getDefaultName(): string
    {
        return Locale::getDisplayRegion($this->region, config('app.locale'));
    }

    /**
     * @todo add summary
     *
     * @return string
     */
    public function getLocaleName(): string
    {
        return Locale::getDisplayRegion($this->region, $this->region);
    }

    /**
     * @todo add summary
     *
     * @return string|null
     */
    public function getRegion(): ?string
    {
        return $this->region;
    }
}
