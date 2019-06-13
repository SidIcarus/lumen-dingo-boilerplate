<?php declare(strict_types=1);

namespace App\Transformer;

use App\Transformer\Base as Transformer;
use App\Value\Localization as Model;

class Localization extends Transformer
{
    public function getResourceKey(): string { return 'localizations'; }

    public function transform(Model $model): array
    {
        // now we manually build the regions
        $regions = [];
        foreach ($model->getRegions() as $region) {
            $regions[] = [
                'code' => $region->getRegion(),
                'default_name' => $region->getDefaultName(),
                'locale_name' => $region->getLocaleName(),
            ];
        }

        return $this->filterData(
            [
                'id' => $model->getLanguage(),
                'language' => [
                    'code' => $model->getLanguage(),
                    'default_name' => $model->getDefaultName(),
                    'locale_name' => $model->getLocaleName(),
                ],
                'regions' => $regions,
            ],
            []
        );
    }
}
