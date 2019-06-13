<?php declare(strict_types=1);

namespace App\Repository;

use App\Criteria\OnlyTrashed as OnlyTrashedCriteria;
use Illuminate\Support\Arr;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Events\RepositoryEntityUpdated;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Repository\Traits\CacheableRepository;

abstract class Base extends BaseRepository implements CacheableInterface
{
    use CacheableRepository {
        paginate as protected paginateExtend;
    }


    public function restore($id)
    {
        return $this->manageDeletes($id, 'restore');
    }


    public function forceDelete(int $id)
    {
        return $this->manageDeletes($id, 'forceDelete');
    }


    public function paginate(
        $limit = null,
        $columns = ['*'],
        $method = 'paginate'
    ) {
        // ignore all when limit already specify
        if ($limit !== null) {
            return $this->paginateExtend($limit, $columns, $method);
        }

        $repoPaginationConfig = config('setting.repository');
        $requestLimit = app('request')->get('limit');

        if ($requestLimit !== null) {
            $limit = $requestLimit >= 0
            && $requestLimit
            <= $repoPaginationConfig['limit_pagination']
                ? $requestLimit : null;
        }

        if ($limit == '0'
            && $repoPaginationConfig['skip_pagination'] === true) {
            return $this->all($columns);
        }

        if ($limit !== null) {
            $limit = (int) $limit;
        }

        return $this->paginateExtend($limit, $columns, $method);
    }


    public function getFieldsSearchable(): array
    {
        $model = $this->makeModel();
        $tableColumns = $model->getConnection()
            ->getSchemaBuilder()
            ->getColumnListing($model->getTable());

        $fieldSearchable = array_map(
            function () : string {
                return 'like';
            },
            array_flip($tableColumns)
        );

        Arr::forget(
            $fieldSearchable,
            ['id', 'created_at', 'updated_at', 'deleted_at']
        );

        return parent::getFieldsSearchable()
            + collect($fieldSearchable)
                ->filter(
                    function ($value, $key) {
                        // polymorphic
                        foreach (['_id', '_type'] as $exclude) {
                            if ($exclude == substr(
                                    $key,
                                    strlen($key) - strlen($exclude),
                                    strlen($key)
                                )) {
                                return false;
                            }
                        }

                        return true;
                    }
                )->toArray();
    }


    private function manageDeletes(int $id, string $method)
    {
        $this->applyScope();

        $temporarySkipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);

        $this->pushCriteria(new OnlyTrashedCriteria());
        $model = $this->find($id);
        $originalModel = clone $model;

        $this->skipPresenter($temporarySkipPresenter);
        $this->resetModel();

        $model->{$method}();

        event(new RepositoryEntityUpdated($this, $originalModel));

        return $this->parserResult($model);
    }
}
