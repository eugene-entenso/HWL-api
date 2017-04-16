<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleSeeder extends Seeder
{
    private $roles = [
        'admin' => 'Administrator',
        'user' => 'User',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->roles as $name => $desc) {
            Role::create([
                'name' => $name,
                'description' => $desc,
            ]);
        }
    }

}
