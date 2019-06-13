<?php

namespace Tests\Auth\User;

use App\Models\Auth\User\User;
use Tests\TestCase;

class DeleteResourceSuccessTest extends TestCase
{
    /**
     * @test
     */
    public function restoreUser()
    {
        $this->loggedInAs();

        $user = factory(User::class)->create();
        $user->delete();

        $this->put($this->route('backend.users.restore', ['id' => $user->getHashedId()]), [], $this->addHeaders());
        $this->assertResponseStatus(200);

        $this->seeInDatabase((new User)->getTable(), [
            'id' => $user->id,
            'deleted_at' => null,
        ]);

        $data = $user->fresh()->toArray();
        $this->seeJson([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
        ]);
    }

    /**
     * @test
     */
    public function purgeUser()
    {
        $this->loggedInAs();

        $user = factory(User::class)->create();
        $user->delete();

        $this->delete($this->route('backend.users.purge', ['id' => $user->getHashedId()]), [], $this->addHeaders());
        $this->assertResponseStatus(204);

        $this->notSeeInDatabase((new User)->getTable(), [
            'id' => $user->id,
        ]);
    }

}
