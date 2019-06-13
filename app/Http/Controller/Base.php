<?php declare(strict_types=1);

namespace App\Http\Controller;

use App\Quality\Hashable;
use App\Transformer\Base as Transformer;
use Closure;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Laravel\Lumen\Routing\Controller;

class Base extends Controller
{
    use Hashable;
    use Helpers;


    protected function paginatorOrCollection(
        $paginatorOrCollection,
        $transformer,
        array $parameters = [],
        ?Closure $after = null
    ): Response {
        $method = '';
        if ($paginatorOrCollection instanceof Paginator) {
            $method = 'paginator';
        } elseif ($paginatorOrCollection instanceof Collection OR $paginatorOrCollection
            instanceof
            SupportCollection) {
            $method = 'collection';
        }

        $response = $this->{$method}(
            $paginatorOrCollection,
            $transformer,
            $this->addResourceKey($transformer, $parameters),
            $after
        );

        return $this->addAvailableIncludes($response, $transformer);
    }


    protected function item($item, $transformer, $parameters = [], Closure $after = null): Response
    {
        $response = $this->response->item(
            $item, $transformer,  $this->addResourceKey($transformer, $parameters), $after
        );

        return $this->addAvailableIncludes($response, $transformer);
    }


    private function addResourceKey(
        $transformer,
        array $parameters
    ): array {
        $resourceKey = $this->checkTransformer($transformer)->getResourceKey();

        return $parameters + ['key' => $resourceKey];
    }


    private function addAvailableIncludes(
        Response $response,
        $transformer
    ): Response {
        return $response->addMeta(
            'include',
            $this->checkTransformer($transformer)->getAvailableIncludes()
        );
    }

    private function checkTransformer($transformer): Transformer
    {
        return is_string($transformer) ? app($transformer) : $transformer;
    }
}
