<?php declare(strict_types=1);

use Illuminate\Database\Seeder;

class AuthSeeder extends Seeder
{

    public function run()
    {
        $this->call('RolesSeeder');
        $this->call('UsersTableSeeder');
    }
}
