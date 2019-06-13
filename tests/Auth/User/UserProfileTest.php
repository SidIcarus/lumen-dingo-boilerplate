<?php declare(strict_types=1);

namespace Tests\Auth\User;

use Tests\TestCase;

class UserProfileTest extends TestCase
{

    public function getProfile($roleName, $status)
    {
        if (!empty($roleName)) {
            $userData = collect($this->loggedInAs($roleName))->only(
                [
                    'first_name',
                    'last_name',
                    'email',
                ]
            )->toArray();
        }
        $this->get($this->route('frontend.users.profile'), $this->addHeaders());

        if (!empty($roleName)) {
            $this->seeJson($userData);
        }
        $this->assertResponseStatus($status);
    }
}
