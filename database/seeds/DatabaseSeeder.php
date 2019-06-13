<?php declare(strict_types=1);

use Illuminate\Database\Seeder;
use Prettus\Repository\Helpers\CacheKeys;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('AuthSeeder');

        app('cache')->flush();
        @unlink(CacheKeys::getFileKeys());
    }
}
