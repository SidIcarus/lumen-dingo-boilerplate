<?php declare(strict_types=1);

namespace Adventive\Http\Middleware;

use ArrayIterator;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

final class Localization
{

    public function handle(Request $request, Closure $next): Response
    {
        $locale = $this->validateLanguage($this->getLocale($request));

        if ($locale === null) {
            // we have not found any language that is supported
            abort(Response::HTTP_PRECONDITION_FAILED, 'Unsupported Language.');
        }

        app('translator')->setLocale($locale);

        $response = $next($request);
        $response->headers->set('Content-Language', $locale);

        return $response;
    }


    private function validateLanguage($requestLanguages): ?string
    {
        // split it up by ","
        $languages = explode(',', $requestLanguages);

        // we need an ArrayIterator because we will be extending the FOREACH
        // below dynamically!
        $language_iterator = new ArrayIterator($languages);

        $supported_languages = $this->getSupportedLanguages();

        foreach ($language_iterator as $language) {
            // split it up by ";"
            $locale = explode(';', $language);

            $current_locale = $locale[0];

            // now check, if this locale is "supported"
            if (in_array($current_locale, $supported_languages, true)) {
                return $current_locale;
            }

            // now check, if the language to be checked is in the form of de-DE
            if (Str::contains($current_locale, '-')) {
                // extract the "main" part ("de") and append it to the end of
                // the languages to be checked
                $base = explode('-', $current_locale);
                $language_iterator[] = $base[0];
            }
        }

        return null;
    }


    private function getLocale(Request $request): string
    {
        return $request->hasHeader('Accept-Language')
            ? $request->header('Accept-Language')
            : config('app.locale');
    }


    private function getSupportedLanguages(): array
    {
        $supported_locales = [];

        foreach (config('localization.supported_languages') as $key => $value) {
            // it is a "simple" language code (e.g., "en")!
            if (!is_array($value)) {
                $supported_locales[] = $value;
            }

            // it is a combined language-code (e.g., "en-US")
            if (is_array($value)) {
                foreach ($value as $v) {
                    $supported_locales[] = $v;
                }
                $supported_locales[] = $key;
            }
        }

        return $supported_locales;
    }
}
