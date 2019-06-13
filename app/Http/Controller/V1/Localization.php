<?php declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Transformers\LocalizationTransformer;
use App\Values\Localizations\Localization;
use Dingo\Api\Http\Response;


class LocalizationController extends Controller
{

    public function index(): Response
    {
        $localizations = collect();

        foreach (config('localization.supported_languages') as $key => $value) {
            // it is a simple key
            if (!is_array($value)) {
                $localizations->push(new Localization($value));
            } else { // it is a composite key
                $localizations->push(new Localization($key, $value));
            }
        }

        return $this->paginatorOrCollection(
            $localizations,
            LocalizationTransformer::class
        );
    }
}
