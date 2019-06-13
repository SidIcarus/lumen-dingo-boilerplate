<?php declare(strict_types=1);
namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface BaseRepositoryInterface
 *
 * @package App\Repositories
 * @method \Prettus\Repository\Eloquent\BaseRepository pushCriteria(\Prettus\Repository\Contracts\CriteriaInterface $param)
 * @method \Illuminate\Database\Eloquent\Model makeModel()
 * @method model()
 */
interface BaseRepositoryInterface extends RepositoryInterface
{
    /**
     * @param $id
     *
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function restore($id);

    /**
     * @param int $id
     *
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function forceDelete(int $id);
}
