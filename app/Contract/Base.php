<?php declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Exceptions\RepositoryException;


interface BaseRepositoryInterface extends RepositoryInterface
{

    public function restore($id);


    public function forceDelete(int $id);
}
