<?php declare(strict_types=1);

namespace Tests\Auth\Authorization;

class RoleManagementTest extends BaseRole
{

    public function validationRole($routeName)
    {
        $this->loggedInAs();

        $route = "backend.roles.$routeName";
        $paramNoData = [
            'name' => '',
        ];
        switch ($routeName) {
            case 'store':
                $this->post($this->route($route), $paramNoData, $this->addHeaders());
                break;
            case 'update':
                $this->put(
                    $this->route(
                        $route,
                        [
                            'id' => $this->createRole()->getHashedId(),
                        ]
                    ),
                    $paramNoData,
                    $this->addHeaders()
                );
                break;
        }
        $this->assertResponseStatus(422);
        $this->seeJson(
            [
                'name' => ['The name field is required.'],
            ]
        );
    }


    public function defaultRoleNotAllowed($verbMethod, $routeName)
    {
        $this->loggedInAs();
        $this->{$verbMethod}(
            $this->route(
                $routeName,
                [
                    'id' => $this->getByRoleName('system')->getHashedId(),
                ]
            ),
            [],
            $this->addHeaders()
        );
        $this->assertResponseStatus(403);
        $this->seeJson(
            [
                'message' => 'You cannot update/delete default role.',
            ]
        );
    }


    public function storeRoleSuccess()
    {
        $this->loggedInAs();

        $data = [
            'name' => 'test new role',
        ];
        $this->post($this->route('backend.roles.store'), $data, $this->addHeaders());

        $this->assertResponseStatus(201);
        $this->seeJson($data);
    }


    public function updateRoleSuccess()
    {
        $this->loggedInAs();
        $roleNameTest = 'im role name';

        $role = $this->createRole($roleNameTest);

        $data = [
            'name' => $roleNameTest . ' new',
        ];

        $this->put(
            $this->route(
                'backend.roles.update',
                [
                    'id' => $role->getHashedId(),
                ]
            ),
            $data,
            $this->addHeaders()
        );

        $this->assertResponseStatus(200);
        $this->seeJson($data);
    }


    public function updateDuplicateRole()
    {
        $this->loggedInAs();
        $duplicateNameTest = 'im duplicate role name';

        $this->createRole($duplicateNameTest);

        $role = $this->createRole('another role name');

        $data = [
            'name' => $duplicateNameTest,
        ];

        $this->put(
            $this->route(
                'backend.roles.update',
                [
                    'id' => $role->getHashedId(),
                ]
            ),
            $data,
            $this->addHeaders()
        );

        $this->assertResponseStatus(422);
        $this->seeJson(
            [
                'message' => "A role `{$duplicateNameTest}` already exists for guard `api`.",
            ]
        );
    }


    public function storeDuplicateRole()
    {
        $this->loggedInAs();
        $roleNameTest = 'im duplicate role name';

        $this->createRole($roleNameTest);

        $data = [
            'name' => $roleNameTest,
        ];
        $this->post($this->route('backend.roles.store'), $data, $this->addHeaders());

        $this->assertResponseStatus(422);
        $this->seeJson(
            [
                'message' => "A role `$roleNameTest` already exists for guard `api`.",
            ]
        );
    }
}
