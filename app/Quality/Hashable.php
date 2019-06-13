<?php declare(strict_types=1);

namespace App\Quality;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

trait Hashable
{

    public function decodeHash(string $hash)
    {
        $decoded = app('hashids')->decode($hash);

        if (empty($decoded)) {
            throw new BadRequestHttpException('Invalid hashed id.');
        }

        return $decoded[0];
    }


    public function getHashedId(string $key = 'id'): string
    {
        return app('hashids')->encode($this->{$key});
    }
}
