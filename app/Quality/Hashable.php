<?php declare(strict_types=1);

namespace App\Traits;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

trait Hashable
{
    /**
     * @todo add summary
     *
     * @param string $hash
     *
     * @return mixed
     *
     * @throws BadRequestHttpException
     */
    public function decodeHash(string $hash)
    {
        $decoded = app('hashids')->decode($hash);

        if (empty($decoded)) {
            throw new BadRequestHttpException('Invalid hashed id.');
        }

        return $decoded[0];
    }

    /**
     * @todo add summary
     *
     * @param string $key
     *
     * @return string
     */
    public function getHashedId(string $key = 'id'): string
    {
        return app('hashids')->encode($this->{$key});
    }
}
