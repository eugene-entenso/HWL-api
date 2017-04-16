<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserSeeder extends Seeder
{
    private $users = [
        [
            'status' => 1,
            'role' => 'admin',
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'password' => 'admin',
        ],
        [
            'status' => 1,
            'role' => 'user',
            'name' => 'user',
            'email' => 'user@mail.com',
            'password' => 'user',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->users as $user) {
            $user['password'] = \Illuminate\Support\Facades\Hash::make($user['password']);
            $role = Role::where(['name' => $user['role']])->first();
            if (!$role) {
                continue;
            }
            unset($user['role']);
            $user = User::create($user);
            $user->roles()->attach($role->getKey());
        }
    }

}
