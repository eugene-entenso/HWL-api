<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionSeeder extends Seeder
{
    private $permissions = [
        // user
        [
            'name' => 'user:index',
            'description' => 'users'
        ],
        [
            'name' => 'user:create',
            'description' => 'create user',
        ],
        [
            'name' => 'user:update',
            'description' => 'update user',
        ],
        [
            'name' => 'user:delete',
            'description' => 'delete user',
        ],
        // role
        [
            'name' => 'role:index',
            'description' => 'roles',
        ],
        [
            'name' => 'role:create',
            'description' => 'create role',
        ],
        [
            'name' => 'role:update',
            'description' => 'update role',
        ],
        [
            'name' => 'role:delete',
            'description' => 'delete role',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->permissions as $permission) {
            Permission::create($permission);
        }
    }

}
