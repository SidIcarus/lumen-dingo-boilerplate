<?php declare(strict_types=1);

namespace App\Criterion\Eloquent;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ThisWhereEqualsCriteria implements CriteriaInterface
{
    /**
     * @var string
     */
    protected $column;

    /**
     * @var string
     */
    protected $value;

    public function __construct(string $column, string $value)
    {
        $this->column = $column;
        $this->value = $value;
    }

    /**
     * Apply criteria in query repository
     *
     * @param $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where($this->column, $this->value);
    }
}
