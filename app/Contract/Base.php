<?php declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Interface BaseRepositoryInterface
 *
 * @package App\Repositories
 * @method \Prettus\Repository\Eloquent\BaseRepository
 *     pushCriteria(\Prettus\Repository\Contracts\CriteriaInterface $param)
 * @method Model makeModel()
 * @method model()
 */
interface BaseRepositoryInterface extends RepositoryInterface
{
    /**
     * @param $id
     *
     * @return mixed
     * @throws RepositoryException
     */
    public function restore($id);

    /**
     * @param int $id
     *
     * @return mixed
     * @throws RepositoryException
     */
    public function forceDelete(int $id);
}
