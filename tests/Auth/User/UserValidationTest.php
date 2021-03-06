<?php declare(strict_types=1);

namespace Tests\Auth\User;

use App\Models\Auth\User\User;
use Tests\TestCase;

class UserValidationTest extends TestCase
{

    public function uniqueEmail()
    {
        $this->loggedInAs();

        $uniqueEmail = 'my@email.com';

        factory(User::class)->create(['email' => $uniqueEmail]);

        $user = factory(User::class)->create(['email' => 'xx' . $uniqueEmail]);

        $this->put(
            $this->route(
                'backend.users.update',
                 ['id' => $user->getHashedId()]
            ),
            ['email' => $uniqueEmail],
            $this->addHeaders()
        );

        $this->assertResponseStatus(422);
        $this->seeJson(
            [
                'email' => ['The email has already been taken.'],
            ]
        );
    }
}
